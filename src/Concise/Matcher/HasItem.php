<?php

namespace Concise\Matcher;

class HasItem extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has key and value item.';

	const SPLIT_SYNTAX = '?:array has key ?:string with value ?';

	public function supportedSyntaxes()
	{
		return array(
			self::SPLIT_SYNTAX => self::DESCRIPTION,
			'?:array has item ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === self::SPLIT_SYNTAX) {
			return $this->match(null, array($data[0], array($data[1] => $data[2])));
		}
		return $data[0] == $data[1];
	}
}
