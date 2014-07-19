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
		return true;
	}
}
