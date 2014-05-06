<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	protected $keywords = array(
		'equal',
		'equals',
		'is',
		'to',
		'true'
	);

	/** @var \Concise\TestCase */
	protected $testCase;

	public function __construct(TestCase $testCase)
	{
		$this->testCase = $testCase;
	}

	/**
	 * @return \Concise\Assertion
	 */
	public function compile($string)
	{
		$matcher = new \Concise\Matcher\EqualTo();
		$assertion = new Assertion($string, $matcher, $this->testCase->getData());
		return $assertion;
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

	public function getPlaceholders($assertion)
	{
		$words = explode(" ", $assertion);
		$placeholders = array();
		foreach($words as $word) {
			if(!in_array($word, $this->keywords)) {
				$placeholders[] = $word;
			}
		}
		return $placeholders;
	}

	public function getDataForPlaceholders(array $placeholders, array $data)
	{
		$result = array();
		foreach($placeholders as $placeholder) {
			if(!array_key_exists($placeholder, $data)) {
				// TEST
				throw new \Exception("No such attribute '$placeholder'.");
			}
			$result[] = $data[$placeholder];
		}
		return $result;
	}
}
