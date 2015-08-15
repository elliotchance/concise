<?php

namespace Concise;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;
use Concise\Matcher\Syntax;
use Concise\Services\ValueDescriptor;
use Concise\Services\ValueRenderer;
use Concise\Syntax\Lexer;
use Concise\Syntax\Token\Attribute;
use Concise\Validation\ArgumentChecker;
use Concise\Validation\DataTypeChecker;
use Exception;
use InvalidArgumentException;
use PHPUnit_Framework_AssertionFailedError;
use ReflectionClass;

class Assertion
{
    /**
     * @var \Concise\Matcher\AbstractMatcher
     */
    protected $matcher;

    /**
     * @var string
     */
    protected $assertionString;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \PHPUnit_Framework_TestCase
     */
    protected $testCase = null;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $originalSyntax = '';

    /**
     * @var string
     */
    protected $failureMessage = '';

    /**
     * @param string                  $assertionString
     * @param Matcher\AbstractMatcher $matcher
     * @param array                   $data
     */
    public function __construct(
        $assertionString,
        Matcher\AbstractMatcher $matcher,
        array $data = array()
    ) {
        ArgumentChecker::check($assertionString, 'string');

        $this->assertionString = $assertionString;
        $this->matcher = $matcher;
        $this->data = $data;
    }

    /**
     * @param string $originalSyntax
     */
    public function setOriginalSyntax($originalSyntax)
    {
        ArgumentChecker::check($originalSyntax, 'string');

        $this->originalSyntax = $originalSyntax;
    }

    /**
     * @param TestCase $testCase
     */
    public function setTestCase(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * @return string
     */
    public function getAssertion()
    {
        return $this->assertionString;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \Concise\Matcher\AbstractMatcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param Attribute $arg
     * @param integer   $index
     * @param           $argument
     * @throws Exception
     */
    protected function throwExceptionForInvalidArgument($arg, $index, $argument)
    {
        $renderer = new ValueRenderer();
        $acceptedTypes = implode(" or ", $arg->getAcceptedTypes());
        $message = sprintf(
            "Argument %d (%s) must be %s.",
            $index,
            $renderer->render($argument),
            $acceptedTypes
        );
        throw new Exception($message);
    }

    /**
     * @param  array $arguments
     * @throws Exception
     * @return array
     */
    protected function checkDataTypes(array $arguments)
    {
        $checker = new DataTypeChecker();
        $checker->setContext($this->getData());
        $lexer = new Lexer();
        $parse = $lexer->parse($this->originalSyntax);
        /** @var $args \Concise\Syntax\Token\Attribute[] */
        $args = $parse['arguments'];
        $len = count($args);
        $r = array();
        for ($i = 0; $i < $len; ++$i) {
            try {
                $r[] = $checker->check(
                    $args[$i]->getAcceptedTypes(),
                    $arguments[$i]
                );
            } catch (InvalidArgumentException $e) {
                $this->throwExceptionForInvalidArgument(
                    $args[$i],
                    $i + 1,
                    $arguments[$i]
                );
            }
        }

        return $r;
    }

    protected function checkDataTypesIfOriginalSyntaxWasProvided(array $args)
    {
        if ('' !== $this->originalSyntax) {
            $args = $this->checkDataTypes($args);
        }

        return $args;
    }

    /**
     * @param string $syntax
     * @param array  $args
     * @return string
     */
    protected function getFailureMessage($syntax, array $args)
    {
        $message = $this->failureMessage;
        if (!$message) {
            $message =
                $this->getMatcher()->renderFailureMessage($syntax, $args);
        }

        return $message;
    }

    protected function getArgumentsAndValidate(array $arguments)
    {
        $args = array();
        $data = $this->getData();
        $len = count($arguments);
        for ($i = 0; $i < $len; ++$i) {
            $arg = $arguments[$i];
            if ($arg instanceof Attribute) {
                $args[$i] = $data[(string)$arg];
            } else {
                $args[$i] = $arg;
            }
        }

        $args = $this->checkDataTypesIfOriginalSyntaxWasProvided($args);

        return $args;
    }

    /**
     * @param array  $args
     * @param string $syntax
     * @return boolean
     */
    protected function performMatch($syntax, array $args)
    {
        if (substr($syntax, strlen($syntax) - 10) == 'on error ?') {
            $syntax = trim(substr($syntax, 0, 10));
        }
        try {
            $reflectionClass = new ReflectionClass($this->getMatcher());
            foreach ($reflectionClass->getMethods() as $method) {
                $doc = $method->getDocComment();
                $nested = strpos($doc, '@nested') !== false;

                foreach (explode("\n", $doc) as $line) {
                    $pos = strpos($line, '@syntax');
                    if ($pos !== false) {
                        $s = new Syntax(
                            trim(substr($line, $pos + 7)),
                            $method->getDeclaringClass()->getName() .
                            '::' .
                            $method->getName()
                        );
                        if ($s->getRawSyntax() == $syntax) {
                            $m = $method->getName();
                            $matcher = $this->getMatcher();
                            $matcher->setData($args);
                            // @todo: remove $this->originalSyntax, $args after migration
                            $answer = $matcher->$m(
                                $this->originalSyntax,
                                $args
                            );

                            if (!$nested && true !== $answer && null !== $answer
                            ) {
                                $message = $this->getFailureMessage(
                                    $syntax,
                                    $args
                                );
                                throw new PHPUnit_Framework_AssertionFailedError(
                                    $message
                                );
                            }

                            return array($answer, $nested);
                        }
                    }
                }
            }

            // @todo delete this, its an error
            if (!method_exists($this->getMatcher(), 'match')) {
                throw new Exception('a');
            }

            return array($this->getMatcher()->match($this->originalSyntax, $args), false);
        } catch (DidNotMatchException $e) {
            $message =
                $e->getMessage() ?: $this->getFailureMessage($syntax, $args);
            throw new PHPUnit_Framework_AssertionFailedError($message);
        }
    }

    /**
     * @throws PHPUnit_Framework_AssertionFailedError
     * @return boolean
     */
    protected function executeAssertion()
    {
        $lexer = new Lexer();
        $result = $lexer->parse($this->getAssertion());
        $args = $this->getArgumentsAndValidate($result['arguments']);

        list($answer, $nested) = $this->performMatch($result['syntax'], $args);

        if (!$nested && !$this->getMatcher() instanceof AbstractNestedMatcher &&
            true !== $answer && null !== $answer
        ) {
            $message = $this->getFailureMessage($result['syntax'], $args);
            throw new PHPUnit_Framework_AssertionFailedError($message);
        }

        return $answer;
    }

    /**
     * @return boolean
     */
    public function run()
    {
        $r = $this->executeAssertion();
        $this->testCase->assertTrue(true);
        return $r;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $excludeKeys = array_keys(TestCase::getPHPUnitProperties());
        $excludeKeys[] = '__dataSet';

        $renderer = new ValueRenderer();
        $descriptor = new ValueDescriptor();
        $r = "";
        foreach ($this->getData() as $k => $v) {
            if (!in_array($k, $excludeKeys)) {
                $r .= "\n  $k (" . $descriptor->describe($v) . ") = " .
                    $renderer->render($v);
            }
        }

        if ('' !== $r) {
            $r = "$r\n";
        }

        return $r;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        if ('' === $this->description) {
            return $this->getAssertion();
        }

        return $this->description . " (" . $this->getAssertion() . ")";
    }

    public function setFailureMessage($message)
    {
        $this->failureMessage = $message;
        return null;
    }
}
