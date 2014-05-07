<?php

namespace Concise\Matcher;

class Null extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return in_array($syntax, array('? is null', '? is not null'));
	}

	public function match(array $data = array())
	{
		if(null === $data[0]) {
			return AbstractMatcher::SUCCESS;
		}
		// @todo fix this and write a test
		return 'bad';
	}
}
