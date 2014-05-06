<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	protected $keywords = array(
		'equal',
		'equals',
		'is',
		'to'
	);

	/** @var \Concise\TestCase */
	protected $testCase;

	public function __construct(TestCase $testCase)
	{
		$this->testCase = $testCase;
	}

	public function compile($string)
	{
		$matcher = new \Concise\Matcher\EqualTo();
		$matcher->setData($this->testCase->getData());
		return $matcher;
	}

	public function translateAssertionToSyntax($assertion)
	{
		$words = explode(" ", $assertion);
		$syntax = array();
		foreach($words as $word) {
			if(in_array($word, $this->keywords)) {
				$syntax[] = $word;
			}
			else {
				$syntax[] = '?';
			}
		}
		return implode(' ', $syntax);
	}

	public function matcherIsRegistered($class)
	{
		return array_key_exists($class, $this->matchers);
	}

	public function registerMatcher(Matcher\AbstractMatcher $matcher)
	{
		$matcherClass = get_class($matcher);
		if(array_key_exists($matcherClass, $this->matchers)) {
			return false;
		}
		$this->matchers[$matcherClass] = $matcher;
		return true;
	}

	public function getKeywords()
	{
		return $this->keywords;
	}
}
