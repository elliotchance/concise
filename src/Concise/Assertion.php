<?php

namespace Concise;

use Concise\Core\ArgumentChecker;
use Concise\Core\DidNotMatchException;
use Concise\Core\ValueDescriptor;
use Concise\Core\ValueRenderer;
use Concise\Module\AbstractModule;
use Exception;
use PHPUnit_Framework_AssertionFailedError;

class Assertion
{
    /**
     * @var AbstractModule
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
     * @param string         $assertionString
     * @param AbstractModule $matcher
     * @param array          $data
     */
    public function __construct(
        $assertionString,
        AbstractModule $matcher,
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
     * @return AbstractModule
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
        $message = null;
        try {
            $syntaxes = $this->getMatcher()->getSyntaxes();

            foreach ($syntaxes as $s) {
                if ($s->getRawSyntax() == $syntax) {
                    $matcher = $this->getMatcher();
                    $matcher->setData($args);
                    $matcher->syntax = $s;
                    $m = $s->getMethod();
                    return $matcher->$m();
                }
            }
        } catch (DidNotMatchException $e) {
            $message =
                $e->getMessage() ?: $this->getFailureMessage($syntax, $args);
        }
        throw new PHPUnit_Framework_AssertionFailedError($message);
    } // @codeCoverageIgnore

    /**
     * @throws PHPUnit_Framework_AssertionFailedError
     * @return boolean
     */
    protected function executeAssertion()
    {
        $lexer = new Lexer();
        $result = $lexer->parse($this->getAssertion());
        $args = $this->getArgumentsAndValidate($result['arguments']);

        return $this->performMatch($result['syntax'], $args);
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
