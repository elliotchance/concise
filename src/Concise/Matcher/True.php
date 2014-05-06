<?php

namespace Concise\Matcher;

class True extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return $syntax === 'true';
	}

	public function match(array $data = array())
	{
		return AbstractMatcher::SUCCESS;
	}
}
