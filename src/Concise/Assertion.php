<?php

namespace Concise;

use \Concise\Syntax\Lexer;
use \Concise\Services\ValueRenderer;
use \Concise\Services\ValueDescriptor;
use \Concise\Services\DataTypeChecker;
use \Concise\TestCase;

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
	 * @param string                  $assertionString
	 * @param Matcher\AbstractMatcher $matcher
	 * @param array                   $data
	 */
	public function __construct($assertionString, Matcher\AbstractMatcher $matcher, array $data = array())
	{
		$this->assertionString = $assertionString;
		$this->matcher = $matcher;
		$this->data = $data;
	}

	/**
	 * @param string $originalSyntax
	 */
	public function setOriginalSyntax($originalSyntax)
	{
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
	 * @param string $code
	 * @return boolean
	 */
	protected function evalCode($code)
	{
		$self = (object) $this->getData();
		$lastError = error_get_last();
		$r = false;
		@eval("\$r = $code;");
		if($lastError != error_get_last()) {
			$error = error_get_last();
			throw new \Exception("Could not compile code block '$code': {$error['message']}");
		}
		return $r;
	}

	/**
	 * @param  array $arguments
	 * @return array
	 */
	protected function checkDataTypes(array $arguments)
	{
		$checker = new DataTypeChecker();
		$checker->setContext($this->getData());
		$lexer = new Lexer();
		$parse = $lexer->parse($this->originalSyntax);
		$args = $parse['arguments'];
		$len = count($args);
		$r = array();
		for($i = 0; $i < $len; ++$i) {
			try {
				$r[] = $checker->check($args[$i]->getAcceptedTypes(), $arguments[$i]);
			}
			catch(\InvalidArgumentException $e) {
				$acceptedTypes = implode(" or ", $args[$i]->getAcceptedTypes());
				throw new \Exception("Argument " . ($i + 1) . " (" . $arguments[$i] . ") must be $acceptedTypes.");
			}
		}
		return $r;
	}

	/**
	 * @return void
	 */
	protected function executeAssertion()
	{
		$lexer = new Lexer();
		$result = $lexer->parse($this->getAssertion());
		$args = array();

		$data = $this->getData();
		$len = count($result['arguments']);
		for($i = 0; $i < $len; ++$i) {
			$arg = $result['arguments'][$i];
			if($arg instanceof \Concise\Syntax\Token\Attribute) {
				$args[$i] = $data[(string) $arg];
			}
			else if($arg instanceof \Concise\Syntax\Token\Code) {
				$args[$i] = $this->evalCode((string) $arg);
			}
			else {
				$args[$i] = $arg;
			}
		}

		if('' !== $this->originalSyntax) {
			$args = $this->checkDataTypes($args);
		}

		$answer = $this->getMatcher()->match($this->originalSyntax, $args);
		if(true === $answer || null === $answer) {
			return;
		}
		$message = $this->getMatcher()->renderFailureMessage($result['syntax'], $args);
		throw new \PHPUnit_Framework_AssertionFailedError($message);
	}

	public function run()
	{
		$this->executeAssertion();
		$this->testCase->assertTrue(true);
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
		foreach($this->getData() as $k => $v) {
			if(!in_array($k, $excludeKeys)) {
				$r .= "\n  $k (" . $descriptor->describe($v) . ") = " . $renderer->render($v);
			}
		}

		if('' !== $r) {
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
		if('' === $this->description) {
			return $this->getAssertion();
		}
		return $this->description . " (" . $this->getAssertion() . ")";
	}
}
