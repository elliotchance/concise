<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	protected static $instance = null;

	protected $keywords = array(
		'equal',
		'equals',
		'is',
		'to',
		'true'
	);

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
		$syntax = $this->translateAssertionToSyntax($string);
		$matcher = $this->getMatcherForSyntax($syntax);
		$assertion = new Assertion($string, $matcher, $data);
		return $assertion;
	}

	public function translateAssertionToSyntax($assertion)
	{
		$lexer = new Lexer();
		$result = $lexer->parse($assertion);
		return $result['syntax'];
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
