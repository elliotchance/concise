<?php

namespace Concise\Matcher;

class IsAnInteger extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an int',
			'? is an integer',
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_int($data[0]);
	}
}
