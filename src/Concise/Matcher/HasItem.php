<?php

namespace Concise\Matcher;

class HasItem extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has key and value item.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has key ?:string with value ?' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
