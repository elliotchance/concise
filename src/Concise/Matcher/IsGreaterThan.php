<?php

namespace Concise\Matcher;

class IsGreaterThan extends AbstractMatcher
{
	const DESCRIPTION = 'A number is greater than another number.';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is greater than ?:number' => self::DESCRIPTION,
			'?:number greater than ?:number' => self::DESCRIPTION,
			'?:number gt ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] > $data[1];
	}
}
