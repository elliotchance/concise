<?php

namespace Concise;

class Assertion
{
	/** @var \Concise\Matcher\AbstractMatcher */
	protected $matcher;

	protected $assertionString;

	protected $data = array();

	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	public function __construct($assertionString, Matcher\AbstractMatcher $matcher, array $data = array())
	{
		$this->assertionString = $assertionString;
		$this->matcher = $matcher;
		$this->data = $data;
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

	protected function executeAssertion()
	{
		$lexer = new Lexer();
		$result = $lexer->parse($this->getAssertion());

		$data = $this->getData();
		for($i = 0; $i < count($result['arguments']); ++$i) {
			$arg = $result['arguments'][$i];
			if($arg instanceof Attribute) {
				$result['arguments'][$i] = $data[$arg->getName()];
			}
		}
		return $this->getMatcher()->match($result['syntax'], $result['arguments']);
	}

	public function fail($reason)
	{
		$this->testCase->fail($reason);
	}

	public function success()
	{
		$this->testCase->assertTrue(true);
	}

	public function run()
	{
		$result = $this->executeAssertion();
		if(Matcher\AbstractMatcher::SUCCESS !== $result) {
			$this->fail($result);
		}
		else {
			$this->success();
		}
	}

	public function __toString()
	{
		$r = "";
		foreach($this->getData() as $k => $v) {
			$r .= "\n  $k = $v";
		}
		return "$r\n";
	}
}
