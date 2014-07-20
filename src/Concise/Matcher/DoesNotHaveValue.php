<?php

namespace Concise\Matcher;

class DoesNotHaveValue extends HasValue
{
	const DESCRIPTION = 'Assert an array does not have any occurrences of the given value.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array does not have value ?' => self::DESCRIPTION,
			'?:array does not contain ?' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}
}
