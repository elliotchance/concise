<?php

namespace Concise\Matcher;

class True extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return $syntax === 'true';
	}

	public function match($syntax, array $data = array())
	{
		return AbstractMatcher::SUCCESS;
	}
}
