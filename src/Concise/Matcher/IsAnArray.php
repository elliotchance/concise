<?php

namespace Concise\Matcher;

class IsAnArray extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an array' => 'Check value is an array',
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_array($data[0]);
	}
}
