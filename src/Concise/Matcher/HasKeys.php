<?php

namespace Concise\Matcher;

class HasKeys extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has contains several keys in any order.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has keys ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		$a = array_keys($data[0]);
		$b = $data[1];
		sort($a);
		sort($b);
		return $a == $b;
	}
}
