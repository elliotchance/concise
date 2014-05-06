<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	public function compile($string)
	{
		return new \Concise\Matcher\EqualTo();
	}

	public function translateAssertionToSyntax($assertion)
	{
		return '? equals ?';
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
