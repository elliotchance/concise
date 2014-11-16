<?php

namespace Concise;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;
use Concise\Services\ValueDescriptor;
use Concise\Services\ValueRenderer;
use Concise\Syntax\Lexer;
use Concise\Syntax\Token\Attribute;
use Concise\Validation\DataTypeChecker;
use Concise\Validation\ArgumentChecker;
use Exception;
use InvalidArgumentException;
use PHPUnit_Framework_AssertionFailedError;

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
    public function __construct($assertionString, Matcher\AbstractMatcher $matcher,
        array $data = array())
    {
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
	 * @param \Concise\TestCase $testCase
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
                $r[] = $checker->check($args[$i]->getAcceptedTypes(), $arguments[$i]);
            } catch (InvalidArgumentException $e) {
                $acceptedTypes = implode(" or ", $args[$i]->getAcceptedTypes());
                $message = sprintf("Argument %d (%s) must be %s.", $i + 1, $arguments[$i],
                    $acceptedTypes);
                throw new Exception($message);
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

    protected function getFailureMessage($syntax, array $args)
    {
        $message = $this->failureMessage;
        if (!$message) {
            $message = $this->getMatcher()->renderFailureMessage($syntax, $args);
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
                $args[$i] = $data[(string) $arg];
            } else {
                $args[$i] = $arg;
            }
        }

        $args = $this->checkDataTypesIfOriginalSyntaxWasProvided($args);

        return $args;
    }

    /**
     * @param array $args
     * @return mixed
     */
    protected function performMatch($syntax, array $args)
    {
        try {
            return $this->getMatcher()->match($this->originalSyntax, $args);
        } catch (DidNotMatchException $e) {
            $message = $e->getMessage() ?: $this->getFailureMessage($syntax, $args);
            throw new PHPUnit_Framework_AssertionFailedError($message);
        }
    }

    /**
     * @throws PHPUnit_Framework_AssertionFailedError
     * @return mixed
     */
    protected function executeAssertion()
    {
        $lexer = new Lexer();
        $result = $lexer->parse($this->getAssertion());
        $args = $this->getArgumentsAndValidate($result['arguments']);

        $answer = $this->performMatch($result['syntax'], $args);

        if (!$this->getMatcher() instanceof AbstractNestedMatcher && true !== $answer &&
            null !== $answer) {
            $message = $this->getFailureMessage($result['syntax'], $args);
            throw new PHPUnit_Framework_AssertionFailedError($message);
        }

        return $answer;
    }

    /**
     * @return mixed
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
                $r .= "\n  $k (" . $descriptor->describe($v) . ") = " . $renderer->render($v);
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
    }
}
