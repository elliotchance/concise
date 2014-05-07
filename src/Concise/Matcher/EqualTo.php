<?php

namespace Concise\Matcher;

class EqualTo extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		// @todo fix this
		return true;
	}

	public function match(array $data = array())
	{
		if($data[0] == $data[1]) {
			return AbstractMatcher::SUCCESS;
		}
		// @todo fix this and write a test
		return 'bad';
	}
}
