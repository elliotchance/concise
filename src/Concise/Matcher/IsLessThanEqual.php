<?php

namespace Concise\Matcher;

class IsLessThanEqual extends AbstractMatcher
{
	const DESCRIPTION = 'A number is less than or equal to another number.';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is less than or equal to ?:number' => self::DESCRIPTION,
			'?:number less than or equal ?:number' => self::DESCRIPTION,
			'?:number lte ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] <= $data[1];
	}

	public function getTags()
	{
		return array(Tag::NUMBERS);
	}
}
