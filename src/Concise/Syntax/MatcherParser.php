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
		return preg_replace('/\\?:[^\s$]+/i', '?', $syntax);
	}

	/**
	 * @param string $syntax
	 * @return array
	 */
	public function getMatcherForSyntax($syntax)
	{
		$rawSyntax = $this->getRawSyntax($syntax);
		if(array_key_exists($rawSyntax, $this->syntaxCache)) {
			return $this->syntaxCache[$rawSyntax];
		}
		throw new \Exception("No such matcher for syntax '$syntax'.");
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

	protected function clearKeywordCache()
	{
		$this->keywords = array();
	}

	public function registerMatcher(\Concise\Matcher\AbstractMatcher $matcher)
	{
		$service = new MatcherSyntaxAndDescription();
		$allSyntaxes = array_keys($service->process($matcher->supportedSyntaxes()));
		foreach($allSyntaxes as $syntax) {
			$rawSyntax = $this->getRawSyntax($syntax);
			if(array_key_exists($rawSyntax, $this->syntaxCache)) {
				throw new \Exception("Syntax '$syntax' is already declared.");
			}
			$this->syntaxCache[$rawSyntax] = array(
				'matcher' => $matcher,
				'originalSyntax' => $syntax,
			);
		}

		$this->matchers[] = $matcher;
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
			if(substr($file, 0, 1) === '.' || in_array($file, array('DidNotMatchException.php', 'AbstractMatcher.php', 'Tag.php'))) {
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

	public function getAllMatcherDescriptions()
	{
		$r = array();
		$service = new MatcherSyntaxAndDescription();
		foreach($this->getMatchers() as $matcher) {
			$syntaxes = $service->process($matcher->supportedSyntaxes());
			foreach($syntaxes as &$syntax) {
				$syntax = array(
					'description' => $syntax,
					'tags' => $matcher->getTags(),
				);
			}
			$r += $syntaxes;
		}
		return $r;
	}
}
