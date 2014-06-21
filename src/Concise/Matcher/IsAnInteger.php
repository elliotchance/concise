<?php

namespace Concise\Matcher;

class IsAnInteger extends AbstractMatcher
{
	const DESCRIPTION = 'Assert value is an integer type.';

	public function supportedSyntaxes()
	{
		return array(
			'? is an int' => self::DESCRIPTION,
			'? is an integer' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_int($data[0]);
	}
}
