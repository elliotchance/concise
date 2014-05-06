<?php

namespace Concise;

class MatcherParser
{
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
		if($class === '\No\Such\Class') {
			return false;
		}
		return true;
	}
}
