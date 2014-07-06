<?php

namespace Concise\Matcher;

class Between extends AbstractMatcher
{
	const DESCRIPTION = 'A number must be between two values (inclusive).';

	public function supportedSyntaxes()
	{
		return array(
			'?:number is between ?:number and ?:number' => self::DESCRIPTION,
			'?:number between ?:number and ?:number' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] >= $data[1];
	}
}
