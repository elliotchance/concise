<?php

namespace Concise\Matcher;

class IsANumber extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is a number' => 'Assert that a value is an integer or floating-point.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_int($data[0]);
	}
}
