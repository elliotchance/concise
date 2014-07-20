<?php

namespace Concise\Matcher;

class IsAnEmptyArray extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array is empty (no elements).';

	public function supportedSyntaxes()
	{
		return array(
			'?:array is empty array' => self::DESCRIPTION,
			'?:array is an empty array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return count($data[0]) === 0;
	}
}
