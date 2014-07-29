<?php

namespace Concise\Matcher;

class IsGreaterThanEqual extends AbstractMatcher
{
	const DESCRIPTION = 'A number is greater than or equal to another number.';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is greater than or equal to ?:number' => self::DESCRIPTION,
			'?:number greater than or equal ?:number' => self::DESCRIPTION,
			'?:number gte ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] >= $data[1];
	}

	public function getTags()
	{
		return array(Tag::NUMBERS);
	}
}
