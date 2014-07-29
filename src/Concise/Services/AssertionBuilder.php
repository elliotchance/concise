<?php

namespace Concise\Services;

use \Concise\Syntax\MatcherParser;
use \Concise\Assertion;
use \Concise\Matcher\IsTrue;

class AssertionBuilder
{
	/**
	 * @var array
	 */
	protected $args;

	/**
	 * @param array $args
	 */
	public function __construct(array $args)
	{
		$this->args = $args;
	}

	/**
	 * @return Assertion
	 */
	public function getAssertion()
	{
		$matcherParser = MatcherParser::getInstance();
		if(count($this->args) === 1 && is_bool($this->args[0])) {
			return $matcherParser->compile($this->args[0] ? 'true' : 'false');
		}

		$syntax = array();
		$data = array();
		$argc = count($this->args);
		for($i = 0; $i < $argc; ++$i) {
			if($i % 2 === 0) {
				$name = "arg" . ($i / 2);
				$syntax[] = $name;
				$data[$name] = $this->args[$i];
			}
			else {
				$syntax[] = $this->args[$i];
			}
		}

		$syntaxString = implode(' ', $syntax);
		return $matcherParser->compile($syntaxString, $data);
	}
}
