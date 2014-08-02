<?php

namespace Concise\Matcher;

class DoesNotHaveItem extends HasItem
{
	const DESCRIPTION = 'Assert an array does not have key and value item.';

	const SPLIT_SYNTAX = '?:array does not have key ?:string with value ?';

	public function supportedSyntaxes()
	{
		return array(
			self::SPLIT_SYNTAX => self::DESCRIPTION,
			'?:array does not have item ?:array' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === self::SPLIT_SYNTAX) {
			return !parent::match(null, array($data[0], array($data[1] => $data[2])));
		}
		return !parent::match(null, $data);
	}

	public function getTags()
	{
		return array(Tag::ARRAYS);
	}
}
