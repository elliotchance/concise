<?php

namespace Concise\Matcher;

class IsNotAnInteger extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not an int',
			'? is not an integer',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !is_int($data[0]);
	}
}
