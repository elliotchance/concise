<?php

namespace Concise\Matcher;

class HasItems extends HasItem
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
		foreach($data[1] as $key => $value) {
			if(!parent::match($data[0], array($data[0], array($key => $value)))) {
				return false;
			}
		}
		return true;
	}
}
