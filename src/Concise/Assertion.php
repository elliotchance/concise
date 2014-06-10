<?php

namespace Concise;

use \Concise\Syntax\Lexer;
use \Concise\Services\ValueRenderer;
use \Concise\Services\ValueDescriptor;
use \Concise\Services\DataTypeChecker;

class Assertion
{
	/** @var \Concise\Matcher\AbstractMatcher */
	protected $matcher;

	protected $assertionString;

	protected $data = array();

	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase = null;

	protected $description = '';

	protected $shouldRunPrepare;

	protected $shouldRunFinalize;

	protected $originalSyntax = null;

	public function __construct($assertionString, Matcher\AbstractMatcher $matcher, array $data = array(), $shouldRunPrepare = false, $shouldRunFinalize = false)
	{
		$this->assertionString = $assertionString;
		$this->matcher = $matcher;
		$this->data = $data;
		$this->shouldRunPrepare = $shouldRunPrepare;
		$this->shouldRunFinalize = $shouldRunFinalize;
	}

	public function setOriginalSyntax($originalSyntax)
	{
		$this->originalSyntax = $originalSyntax;
	}

	public function setTestCase(\PHPUnit_Framework_TestCase $testCase)
	{
		$this->testCase = $testCase;
	}
	
	public function getAssertion()
	{
		return $this->assertionString;
	}
	
	public function getData()
	{
		return $this->data;
	}

	public function getMatcher()
	{
		return $this->matcher;
	}

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

	protected function checkDataTypes(array $arguments)
	{
		$checker = new DataTypeChecker();
		$lexer = new Lexer();
		$args = $lexer->parse($this->originalSyntax)['arguments'];
		for($i = 0; $i < count($args); ++$i) {
			try {
				$checker->check($args[$i]->getAcceptedTypes(), $arguments[$i]);
			}
			catch(\InvalidArgumentException $e) {
				$acceptedTypes = implode(" or ", $args[$i]->getAcceptedTypes());
				throw new \Exception("Argument " . ($i + 1) . " (" . $arguments[$i] . ") must be $acceptedTypes.");
			}
		}
	}

	/**
	 * @return boolean|string
	 */
	protected function executeAssertion()
	{
		$lexer = new Lexer();
		$result = $lexer->parse($this->getAssertion());
		$args = array();

		$data = $this->getData();
		for($i = 0; $i < count($result['arguments']); ++$i) {
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

		if(null !== $this->originalSyntax) {
			$this->checkDataTypes($result['arguments']);
		}

		if(true === $this->getMatcher()->match($result['syntax'], $args)) {
			return true;
		}
		return $this->getMatcher()->renderFailureMessage($result['syntax'], $result['arguments']);
	}

	/**
	 * @param boolean|string $reason
	 */
	public function fail($reason)
	{
		if(!is_object($this->testCase)) {
			throw new \Exception();
		}
		$this->testCase->fail($reason);
	}

	public function success()
	{
		$this->testCase->assertTrue(true);
	}

	public function run()
	{
		if($this->shouldRunPrepare()) {
			$this->testCase->prepare();
		}
		$result = $this->executeAssertion();
		if(true === $result) {
			$this->success();
		}
		else {
			$this->fail($result);
		}
		if($this->shouldRunFinalize()) {
			$this->testCase->finalize();
		}
	}

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

	public function getDescription()
	{
		if('' === $this->description) {
			return $this->getAssertion();
		}
		return $this->description . " (" . $this->getAssertion() . ")";
	}

	public function shouldRunPrepare()
	{
		return $this->shouldRunPrepare;
	}

	public function shouldRunFinalize()
	{
		return $this->shouldRunFinalize;
	}

	/**
	 * @param boolean $shouldRunPrepare
	 */
	public function setShouldRunPrepare($shouldRunPrepare)
	{
		$this->shouldRunPrepare = $shouldRunPrepare;
	}

	/**
	 * @param boolean $shouldRunFinalize
	 */
	public function setShouldRunFinalize($shouldRunFinalize)
	{
		$this->shouldRunFinalize = $shouldRunFinalize;
	}
}
