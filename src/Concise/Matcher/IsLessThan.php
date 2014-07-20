<?php

namespace Concise\Matcher;

class IsLessThan extends AbstractMatcher
{
	const DESCRIPTION = 'A number is less than another number.';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is less than ?:number' => self::DESCRIPTION,
			'?:number less than ?:number' => self::DESCRIPTION,
			'?:number lt ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] < $data[1];
	}

	public function getTags()
	{
		return array(Tag::NUMBERS);
	}
}
