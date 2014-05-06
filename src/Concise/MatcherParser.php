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

	public function compile($string)
	{
		return new \Concise\Matcher\EqualTo();
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
}
