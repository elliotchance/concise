<?php

namespace Concise;

class MatcherParser
{
	protected $matchers = array();

	protected static $instance = null;

	protected $keywords = array();

	public function getMatcherForSyntax($syntax)
	{
		$found = array();
		foreach($this->matchers as $matcher) {
			$syntaxes = $matcher->supportedSyntaxes();
			if(in_array($syntax, $syntaxes)) {
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

		$this->registerMatcher(new Matcher\Equals());
		$this->registerMatcher(new Matcher\Boolean());
		$this->registerMatcher(new Matcher\Null());
		$this->registerMatcher(new Matcher\NotEquals());
		$this->registerMatcher(new Matcher\IsAnObject());
		$this->registerMatcher(new Matcher\IsAnArray());
		$this->registerMatcher(new Matcher\IsAnInteger());
	}

	public function getMatchers()
	{
		return $this->matchers;
	}

	protected function getRawKeywords()
	{
		$r = array();
		foreach($this->getMatchers() as $matcher) {
			foreach($matcher->supportedSyntaxes() as $syntax) {
				foreach(explode(' ', $syntax) as $word) {
					if($word !== '?') {
						$r[] = $word;
					}
				}
			}
		}
		$r = array_unique($r);
		sort($r);
		return $r;
	}

	public function getKeywords()
	{
		if(0 === count($this->keywords)) {
			$this->keywords = $this->getRawKeywords();
		}
		return $this->keywords;
	}

	public function getAllSyntaxes()
	{
		$r = array();
		foreach($this->getMatchers() as $matcher) {
			foreach($matcher->supportedSyntaxes() as $syntax) {
				$r[] = $syntax;
			}
		}
		sort($r);
		return $r;
	}
}
