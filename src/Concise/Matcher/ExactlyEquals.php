<?php

namespace Concise\Matcher;

class ExactlyEquals extends AbstractMatcher
{
	const EXACTLY_EQUALS_DESCRIPTION = 'Assert two values match data type and value.';

	public function supportedSyntaxes()
	{
		return array(
			'? is exactly equal to ?' => self::EXACTLY_EQUALS_DESCRIPTION,
			'? exactly equals ?' => self::EXACTLY_EQUALS_DESCRIPTION,
			'? is the same as ?' => self::EXACTLY_EQUALS_DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return ($data[0] === $data[1]);
	}
}
