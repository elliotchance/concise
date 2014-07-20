<?php

namespace Concise\Matcher;

class IsNotAnInteger extends IsAnInteger
{
	const DESCRIPTION = 'Assert a value is not an integer type.';

	public function supportedSyntaxes()
	{
		return array(
			'? is not an int' => self::DESCRIPTION,
			'? is not an integer' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}

	public function getTags()
	{
		return array(Tag::BASIC, Tag::NUMBERS);
	}
}
