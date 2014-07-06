<?php

namespace Concise\Matcher;

class NotBetween extends Between
{
	const DESCRIPTION = 'A number must not be between two values (inclusive).';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is not between ?:number and ?:number' => self::DESCRIPTION,
			'?:number not between ?:number and ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}
}
