<?php

namespace Concise\Matcher;

class IsAnEmptyArray extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array is empty (no elements).';

	public function supportedSyntaxes()
	{
		return array(
			'? is empty array' => self::DESCRIPTION,
			'? is an empty array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
