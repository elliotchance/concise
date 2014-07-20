<?php

namespace Concise\Matcher;

class DoesNotHaveKeys extends HasKeys
{
	const DESCRIPTION = 'Assert an array does not contain any keys.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array does not have keys ?:array' => self::DESCRIPTION,
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
