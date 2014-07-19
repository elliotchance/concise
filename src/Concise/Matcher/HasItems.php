<?php

namespace Concise\Matcher;

class HasItems extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has all key and value items.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has items ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		if(count($data[1]) === 0) {
			return true;
		}
		return $data[0] == $data[1];
	}
}
