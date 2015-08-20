<?php

namespace Concise\Syntax;

use Concise\Assertion;
use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\Syntax;
use Concise\Validation\ArgumentChecker;
use Exception;
use ReflectionClass;
use ReflectionException;

class MatcherParser
{
    /**
     * @var MatcherParser
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $keywords = array();

    /**
     * @var Lexer
     */
    protected $lexer;

    /**
     * @var array
     */
    protected $syntaxCache = array();

    /**
     * @var AbstractMatcher[]
     */
    protected $modules = array();

    public function __construct()
    {
        $this->lexer = new Lexer();
        $this->lexer->setMatcherParser($this);
    }

    /**
     * @param  string $syntax
     * @return string
     */
    protected function getRawSyntax($syntax)
    {
        return preg_replace('/\\?:[^\s$]+/i', '?', $syntax);
    }

    /**
     * @param string $string
     * @param string $substring
     * @return bool
     */
    protected function endsWith($string, $substring)
    {
        return (substr($string, strlen($string) - strlen($substring)) ===
            $substring);
    }

    /**
     * @param string $syntax
     * @param array  $data
     * @throws Exception
     * @return array
     */
    public function getMatcherForSyntax($syntax, array $data = array())
    {
        ArgumentChecker::check($syntax, 'string');

        $rawSyntax = $this->getRawSyntax($syntax);
        $endsWith = ' on error ?';
        $options = array();
        if ($this->endsWith($rawSyntax, $endsWith)) {
            $rawSyntax =
                substr($rawSyntax, 0, strlen($rawSyntax) - strlen($endsWith));
            $options = array(
                'on_error' => $data[count($data) - 1],
            );
        }
        if (array_key_exists($rawSyntax, $this->syntaxCache)) {
            return $this->syntaxCache[$rawSyntax] + $options;
        }

        foreach ($this->modules as $module) {
            $reflectionClass = new ReflectionClass($module);
            foreach($reflectionClass->getMethods() as $method) {
                $doc = $method->getDocComment();
                foreach (explode("\n", $doc) as $line) {
                    $pos = strpos($line, '@syntax');
                    if ($pos !== false) {
                        $s = new Syntax(trim(substr($line, $pos + 7)), $method->getDeclaringClass()->getName() . '::' . $method->getName());
                        if ($s->getRawSyntax() == $rawSyntax) {
                            $class = $s->getClass();
                            $r = array(
                                'matcher' => new $class(),
                                'originalSyntax' => $s->getSyntax(),
                            );
                            if ($this->endsWith(
                                $this->getRawSyntax($syntax),
                                $endsWith
                            )
                            ) {
                                $r['on_error'] = $data[count($data) - 1];
                            }
                            return $r;
                        }
                    }
                }
            }
        }

        throw new NoMatcherFoundException(array($syntax));
    }

    /**
     * @param array $data The data from the test case.
     * @param string $string
     * @return Assertion
     */
    public function compile($string, array $data = array())
    {
        $result = $this->lexer->parse($string);
        $match =
            $this->getMatcherForSyntax($result['syntax'], $result['arguments']);
        $assertion = new Assertion($string, $match['matcher'], $data);
        if (array_key_exists('on_error', $match)) {
            $assertion->setFailureMessage($data[(string)$match['on_error']]);
        }
        $assertion->setOriginalSyntax($match['originalSyntax']);

        return $assertion;
    }

    protected function clearKeywordCache()
    {
        $this->keywords = array();
    }

    /**
     * @param string $rawSyntax
     * @throws Exception If the assertion contains words that are not lower
     *     case.
     */
    protected function throwExceptionIfNotInLowerCase($rawSyntax)
    {
        if (strtolower($rawSyntax) != $rawSyntax) {
            throw new Exception(
                "All assertions ('$rawSyntax') must be lower case."
            );
        }
    }

    /**
     * @param string $rawSyntax
     * @param        $syntax
     * @throws Exception
     */
    protected function throwExceptionIfSyntaxIsAlreadyDeclared(
        $rawSyntax,
        $syntax
    ) {
        if (array_key_exists($rawSyntax, $this->syntaxCache)) {
            throw new Exception("Syntax '$syntax' is already declared.");
        }
    }

    protected function registerSyntax($syntax, AbstractMatcher $matcher)
    {
        $rawSyntax = $this->getRawSyntax($syntax);
        $this->throwExceptionIfNotInLowerCase($rawSyntax);
        $this->throwExceptionIfSyntaxIsAlreadyDeclared($rawSyntax, $syntax);
        $this->syntaxCache[$rawSyntax] = array(
            'matcher' => $matcher,
            'originalSyntax' => $syntax,
        );
    }

    /**
     * @return MatcherParser
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new MatcherParser();
        }

        return self::$instance;
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function isValidMatcher($class)
    {
        try {
            $reflectionClass = new ReflectionClass($class);
            return !$reflectionClass->isAbstract() &&
            is_subclass_of($class, 'Concise\Matcher\AbstractMatcher') &&
            $class != 'Concise\Matcher\AbstractNestedMatcher';
        } catch (ReflectionException $e) {
            return false;
        }
    }

    public function loadModule(AbstractMatcher $module)
    {
        $this->modules[get_class($module)] = $module;
    }

    protected function getWordsForSyntaxes(array $syntaxes)
    {
        $r = array();
        foreach (array_keys($syntaxes) as $syntax) {
            foreach (explode(' ', $syntax) as $word) {
                if ($word[0] !== '?') {
                    $r[] = $word;
                }
            }
        }

        return $r;
    }

    /**
     * @return array
     */
    protected function getRawKeywords()
    {
        $r = array('error', 'on');
        foreach ($this->modules as $module) {
            $reflectionClass = new ReflectionClass($module);
            foreach($reflectionClass->getMethods() as $method) {
                $doc = $method->getDocComment();
                foreach (explode("\n", $doc) as $line) {
                    $pos = strpos($line, '@syntax');
                    if ($pos !== false) {
                        $syntax = new Syntax(trim(substr($line, $pos + 7)), $method->getDeclaringClass()->getName() . '::' . $method->getName());
                        $r = array_merge(
                            $r,
                            $this->getWordsForSyntaxes(
                                array($syntax->getSyntax() => '')
                            )
                        );
                    }
                }
            }
        }

        $r = array_unique($r);
        sort($r);

        return $r;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        if (0 === count($this->keywords)) {
            $this->keywords = $this->getRawKeywords();
        }

        return $this->keywords;
    }
}
