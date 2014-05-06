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

	/**
	 * @param array $data The data from the test case.
	 * @return \Concise\Assertion
	 */
	public function compile($string, array $data)
	{
		$matcher = new \Concise\Matcher\EqualTo();
		$assertion = new Assertion($string, $matcher, $data);
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
				throw new \Exception("No such attribute '$placeholder'.");
			}
			$result[] = $data[$placeholder];
		}
		return $result;
	}
}
