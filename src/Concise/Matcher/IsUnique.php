<?php

namespace Concise\Matcher;

class IsUnique extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:array is unique' => 'Assert that an array only contains unique values.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return count($data[0]) === count(array_unique($data[0]));
	}
}
