<?php

namespace Concise\Matcher;

class DoesNotHaveKey extends HasKey
{
	const DESCRIPTION = 'Assert an array does not have a key.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array does not have key ?:int,string' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}

	public function getTags()
	{
		return array(Tag::ARRAYS);
	}
}
