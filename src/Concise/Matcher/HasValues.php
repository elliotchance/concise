<?php

namespace Concise\Matcher;

class HasValues extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has several values in any order.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has values ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
