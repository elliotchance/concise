<?php

namespace Concise\Matcher;

class HasKeys extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has several keys in any order.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has keys ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		$keys = array_keys($data[0]);
		foreach($data[1] as $key) {
			if(!in_array($key, $keys)) {
				return false;
			}
		}
		return true;
	}

	public function getTags()
	{
		return array(Tag::ARRAYS);
	}
}
