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
		if($data[0] == $data[1]) {
			return AbstractMatcher::SUCCESS;
		}
		return 'bad';
	}
}
