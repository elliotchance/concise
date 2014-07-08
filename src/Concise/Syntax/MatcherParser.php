<?php

namespace Concise\Syntax;

use \Concise\Assertion;
use \Concise\Services\MatcherSyntaxAndDescription;

class MatcherParser
{
	protected $matchers = array();

	protected static $instance = null;

	protected $keywords = array();

	protected $lexer;

	protected $syntaxCache = array();

	public function __construct()
	{
		$this->lexer = new Lexer();
		$this->lexer->setMatcherParser($this);
	}

	protected function getRawSyntax($syntax)
	{
		if(!array_key_exists($syntax, $this->syntaxCache)) {
			$this->syntaxCache[$syntax] = preg_replace('/\\?:[^\s$]+/i', '?', $syntax);
		}
		return $this->syntaxCache[$syntax];
	}

	/**
	 * @param string $syntax
	 * @return array
	 */
	public function getMatcherForSyntax($syntax)
	{
		$found = array();
		foreach($this->matchers as $matcher) {
			$service = new MatcherSyntaxAndDescription();
			$syntaxes = array_keys($service->process($matcher->supportedSyntaxes()));
			foreach($syntaxes as $s) {
				if($this->getRawSyntax($syntax) === $this->getRawSyntax($s)) {
					$found[] = array(
						'matcher' => $matcher,
						'originalSyntax' => $s,
					);
				}
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
	 * @param string $string
	 * @return \Concise\Assertion
	 */
	public function compile($string, array $data = array())
	{
		$result = $this->lexer->parse($string);
		$match = $this->getMatcherForSyntax($result['syntax']);
		$assertion = new Assertion($string, $match['matcher'], $data);
		$assertion->setOriginalSyntax($match['originalSyntax']);
		return $assertion;
	}

	/**
	 * @param string $matcherClass
	 */
	public function matcherIsRegistered($matcherClass)
	{
		foreach($this->matchers as $matcher) {
			if(get_class($matcher) === $matcherClass) {
				return true;
			}
		}
		return false;
	}

	protected function clearKeywordCache()
	{
		$this->keywords = array();
	}

	public function registerMatcher(\Concise\Matcher\AbstractMatcher $m)
	{
		$service = new MatcherSyntaxAndDescription();
		$allSyntaxes = array_keys($service->process($m->supportedSyntaxes()));
		foreach($allSyntaxes as $syntax) {
			foreach($this->matchers as $matcher) {
				$syntaxes = array_keys($service->process($matcher->supportedSyntaxes()));
				foreach($syntaxes as $s) {
					if($this->getRawSyntax($syntax) === $this->getRawSyntax($s)) {
						throw new \Exception("Syntax '$s' is already declared.");
					}
				}
			}
		}

		$this->matchers[] = $m;
		$this->clearKeywordCache();
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

	protected function autoloadAllMatchers()
	{
		foreach(scandir(__DIR__ . "/../Matcher") as $file) {
			if(substr($file, 0, 1) === '.' || in_array($file, array('DidNotMatchException.php', 'AbstractMatcher.php'))) {
				continue;
			}
			$class = "\\Concise\\Matcher\\" . substr($file, 0, strlen($file) - 4);
			$this->registerMatcher(new $class());
		}
	}

	protected function registerMatchers()
	{
		if(count($this->matchers) > 0) {
			throw new \Exception("registerMatchers() can only be called once.");
		}

		$this->autoloadAllMatchers();
	}

	public function getMatchers()
	{
		return $this->matchers;
	}

	protected function getRawKeywords()
	{
		$r = array();
		foreach($this->getMatchers() as $matcher) {
			$service = new MatcherSyntaxAndDescription();
			$syntaxes = $service->process($matcher->supportedSyntaxes());

			foreach(array_keys($syntaxes) as $syntax) {
				foreach(explode(' ', $syntax) as $word) {
					if($word[0] !== '?') {
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
		$service = new MatcherSyntaxAndDescription();
		foreach($this->getMatchers() as $matcher) {
			$r += $service->process($matcher->supportedSyntaxes());
		}
		ksort($r);
		return $r;
	}
}
