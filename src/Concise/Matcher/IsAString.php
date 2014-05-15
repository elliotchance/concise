<?php

namespace Concise\Matcher;

class IsAString extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is a string',
			'? is not a string',
		);
	}

	public function match($syntax, array $data = array())
	{
		$test = is_string($data[0]);
		if('? is a string' === $syntax) {
			return $test;
		}
		return !$test;
	}
}
