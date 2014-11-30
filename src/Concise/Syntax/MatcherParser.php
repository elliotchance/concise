<?php

namespace Concise\Syntax;

use Concise\Assertion;
use Concise\Services\MatcherSyntaxAndDescription;
use Concise\Matcher\AbstractMatcher;
use Concise\Validation\ArgumentChecker;
use Exception;
use ReflectionClass;
use ReflectionException;

class MatcherParser
{
    /**
	 * @var array
	 */
    protected $matchers = array();

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
     */
    protected function endsWith($string, $substring)
    {
        return (substr($string, strlen($string) - strlen($substring)) === $substring);
    }

    /**
     * @param string $syntax
     * @param array $data
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
            $rawSyntax = substr($rawSyntax, 0, strlen($rawSyntax) - strlen($endsWith));
            $options = array(
                'on_error' => $data[count($data) - 1],
            );
        }
        if (array_key_exists($rawSyntax, $this->syntaxCache)) {
            return $this->syntaxCache[$rawSyntax] + $options;
        }
        throw new NoMatcherFoundException(array($syntax));
    }

    /**
	 * @param array $data The data from the test case.
	 * @param string $string
	 * @return \Concise\Assertion
	 */
    public function compile($string, array $data = array())
    {
        $result = $this->lexer->parse($string);
        $match = $this->getMatcherForSyntax($result['syntax'], $result['arguments']);
        $assertion = new Assertion($string, $match['matcher'], $data);
        if (array_key_exists('on_error', $match)) {
            $assertion->setFailureMessage($data[(string) $match['on_error']]);
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
     */
    protected function throwExceptionIfNotInLowerCase($rawSyntax)
    {
        if (strtolower($rawSyntax) != $rawSyntax) {
            throw new Exception("All assertions ('$rawSyntax') must be lower case.");
        }
    }

    /**
     * @param string $rawSyntax
     */
    protected function throwExceptionIfSyntaxIsAlreadyDeclared($rawSyntax, $syntax)
    {
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
	 * @param  \Concise\Matcher\AbstractMatcher $matcher
	 * @return boolean
	 */
    public function registerMatcher(AbstractMatcher $matcher)
    {
        $service = new MatcherSyntaxAndDescription();
        $allSyntaxes = array_keys($service->process($matcher->supportedSyntaxes()));
        foreach ($allSyntaxes as $syntax) {
            $this->registerSyntax($syntax, $matcher);
        }

        $this->matchers[] = $matcher;
        $this->clearKeywordCache();

        return true;
    }

    /**
	 * @return MatcherParser
	 */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new MatcherParser();
            self::$instance->registerMatchers();
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

    protected function autoloadAllMatchers()
    {
        foreach (scandir(__DIR__ . "/../Matcher") as $file) {
            $class = "Concise\\Matcher\\" . substr($file, 0, strlen($file) - 4);
            if ($this->isValidMatcher($class)) {
                $this->registerMatcher(new $class());
            }
        }
    }

    protected function registerMatchers()
    {
        if (count($this->matchers) > 0) {
            throw new Exception("registerMatchers() can only be called once.");
        }

        $this->autoloadAllMatchers();
    }

    /**
	 * @return array
	 */
    public function getMatchers()
    {
        return $this->matchers;
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
        foreach ($this->getMatchers() as $matcher) {
            $service = new MatcherSyntaxAndDescription();
            /** @var $matcher \Concise\Matcher\AbstractMatcher */
            $syntaxes = $service->process($matcher->supportedSyntaxes());
            $r = array_merge($r, $this->getWordsForSyntaxes($syntaxes));
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

    /**
	 * @return array
	 */
    public function getAllMatcherDescriptions()
    {
        $r = array();
        $service = new MatcherSyntaxAndDescription();
        foreach ($this->getMatchers() as $matcher) {
            /** @var $matcher \Concise\Matcher\AbstractMatcher */
            $syntaxes = $service->process($matcher->supportedSyntaxes());
            foreach ($syntaxes as &$syntax) {
                /** @var $matcher \Concise\Matcher\AbstractMatcher */
                $syntax = array(
                    'description' => $syntax,
                    'tags' => $matcher->getTags(),
                    'matcher' => get_class($matcher),
                );
            }
            $r += $syntaxes;
        }

        return $r;
    }
}
