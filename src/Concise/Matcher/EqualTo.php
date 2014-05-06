<?php

namespace Concise\Matcher;

class EqualTo extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return true;
	}

	public function match(array $data = array())
	{
		return true;
	}
}
