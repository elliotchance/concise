<?php

namespace Concise\Matcher;

class HasValue extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has at least one occurrence of the given value.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has value ?' => self::DESCRIPTION,
			'?:array contains ?' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return in_array($data[1], $data[0]);
	}
}
