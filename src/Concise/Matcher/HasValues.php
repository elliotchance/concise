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
		$keys = array_values($data[0]);
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
