<?php

namespace Concise\Matcher;

class IsNotAString extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not a string',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !is_string($data[0]);
	}
}
