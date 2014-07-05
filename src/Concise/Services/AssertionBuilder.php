<?php

namespace Concise\Services;

use \Concise\Syntax\MatcherParser;
use \Concise\Assertion;
use \Concise\Matcher\IsTrue;

class AssertionBuilder
{
	protected $args;

	public function __construct(array $args)
	{
		$this->args = $args;
	}

	public function getAssertion()
	{
		$matcherParser = MatcherParser::getInstance();
		if(count($this->args) === 1 && $this->args[0] === true) {
			return $matcherParser->compile('true');
		}
		if($this->args[0] === false) {
			return $matcherParser->compile('false');
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
