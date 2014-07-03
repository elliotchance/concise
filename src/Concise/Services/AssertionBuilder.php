<?php

namespace Concise\Services;

use \Concise\Syntax\MatcherParser;
use \Concise\Assertion;

class AssertionBuilder
{
	protected $args;

	public function __construct(array $args)
	{
		$this->args = $args;
	}

	public function getAssertion()
	{
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

		$matcherParser = MatcherParser::getInstance();
		$syntaxString = implode(' ', $syntax);
		return $matcherParser->compile($syntaxString, $data);
	}
}
