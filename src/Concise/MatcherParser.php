<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	protected static $instance = null;

	public function getMatcherForSyntax($syntax)
	{
		$found = array();
		foreach($this->matchers as $matcher) {
			if($matcher->matchesSyntax($syntax)) {
				$found[] = $matcher;
			}
		}
		if(count($found) === 0) {
			throw new \Exception("No such matcher for syntax '$syntax'.");
		}
		if(count($found) > 1) {
			throw new \Exception("Ambiguous syntax for '$syntax'.");
		}
		return $found[0];
	}

	/**
	 * @param array $data The data from the test case.
	 * @return \Concise\Assertion
	 */
	public function compile($string, array $data = array())
	{
		$lexer = new Lexer();
		$result = $lexer->parse($string);
		$matcher = $this->getMatcherForSyntax($result['syntax']);
		$assertion = new Assertion($string, $matcher, $data);
		return $assertion;
	}

	public function matcherIsRegistered($matcherClass)
	{
		foreach($this->matchers as $matcher) {
			if(get_class($matcher) === $matcherClass) {
				return true;
			}
		}
		return false;
	}

	public function registerMatcher(Matcher\AbstractMatcher $matcher)
	{
		$this->matchers[] = $matcher;
		return true;
	}

	public function getPlaceholders($assertion)
	{
		$words = explode(" ", $assertion);
		$placeholders = array();
		foreach($words as $word) {
			if(!in_array($word, Lexer::getKeywords())) {
				$placeholders[] = $word;
			}
		}
		return $placeholders;
	}

	protected function getDataForPlaceholder($placeholder, array $data)
	{
		if(!array_key_exists($placeholder, $data)) {
			throw new \Exception("No such attribute '$placeholder'.");
		}
		return $data[$placeholder];
	}

	public function getDataForPlaceholders(array $placeholders, array $data)
	{
		$result = array();
		foreach($placeholders as $placeholder) {
			$result[] = $this->getDataForPlaceholder($placeholder, $data);
		}
		return $result;
	}

	public static function getInstance()
	{
		if(null === self::$instance) {
			self::$instance = new MatcherParser();
			self::$instance->registerMatchers();
		}
		return self::$instance;
	}

	protected function registerMatchers()
	{
		if(count($this->matchers) > 0) {
			throw new \Exception("registerMatchers() can only be called once.");
		}

		$this->registerMatcher(new Matcher\EqualTo());
		$this->registerMatcher(new Matcher\True());
	}

	public function getMatchers()
	{
		return $this->matchers;
	}
}
