<?php

namespace Concise\Matcher;

class HasItem extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has key and value item.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has key ?:string with value ?' => self::DESCRIPTION,
			'?:array has item ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === '?:array has key ?:string with value ?') {
			return $this->match(null, array($data[0], array($data[1] => $data[2])));
		}
		return true;
	}
}
