<?php

namespace Concise;

class Assertion
{
	/** @var \Concise\Matcher\AbstractMatcher */
	protected $matcher;

	protected $assertionString;

	protected $data = array();

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
		$parser = new MatcherParser($this->testCase);
		$placeholders = $parser->getPlaceholders($this->getAssertion());
		$data = $parser->getDataForPlaceholders($placeholders, $this->getData());
		return $this->getMatcher()->match($data);
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
