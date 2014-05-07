<?php

namespace Concise\Matcher;

class EqualTo extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return in_array($syntax, array('? equals ?', '? is equal to ?'));
	}

	public function match($syntax, array $data = array())
	{
		if($data[0] == $data[1]) {
			return AbstractMatcher::SUCCESS;
		}
		// @todo fix this and write a test
		return 'bad';
	}
}
