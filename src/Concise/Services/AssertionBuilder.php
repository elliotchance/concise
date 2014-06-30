<?php

namespace Concise\Services;

use \Concise\Syntax\MatcherParser;

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
		$argc = count($this->args);
		for($i = 0; $i < $argc; ++$i) {
			if($i % 2 === 0) {
				$syntax[] = '?';
			}
			else {
				$syntax[] = $this->args[$i];
			}
		}

		$matcherParser = MatcherParser::getInstance();
		$assertion = $matcherParser->compile(implode(' ', $syntax));
		return $assertion->getMatcher();
	}
}
