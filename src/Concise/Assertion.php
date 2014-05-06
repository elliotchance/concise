<?php

namespace Concise;

class Assertion
{
	/** @var \Concise\Matcher\AbstractMatcher */
	protected $matcher;

	protected $assertionString;

	protected $data = array();

	public function __construct($assertionString, Matcher\AbstractMatcher $matcher, array $data = array())
	{
		$this->assertionString = $assertionString;
		$this->matcher = $matcher;
		$this->data = $data;
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

	public function run(\PHPUnit_Framework_TestCase $testCase)
	{
		$parser = new MatcherParser($testCase);
		$placeholders = $parser->getPlaceholders($this->getAssertion());
		$data = $parser->getDataForPlaceholders($placeholders, $this->getData());
		$testCase->assertTrue($this->getMatcher()->match($data));
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
