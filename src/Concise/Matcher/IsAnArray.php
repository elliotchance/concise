<?php

namespace Concise\Matcher;

class IsAnArray extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an array',
			'? is not an array',
		);
	}

	public function match($syntax, array $data = array())
	{
		$array = is_array($data[0]);
		if('? is an array' === $syntax) {
			return $array;
		}
		return !$array;
	}
}
