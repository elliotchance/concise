<?php

namespace Concise\Matcher;

class IsAnInteger extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an int',
			'? is an integer',
			'? is not an int',
			'? is not an integer',
		);
	}

	public function match($syntax, array $data = array())
	{
		$int = is_int($data[0]);
		if(strpos($syntax, 'not') === false) {
			return $int;
		}
		return !$int;
	}
}
