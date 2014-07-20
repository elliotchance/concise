<?php

namespace Concise\Matcher;

use \Concise\Services\ConvertToString;

class StringDoesNotEndWith extends StringEndsWith
{
	public function supportedSyntaxes()
	{
		return array(
			'? does not end with ?' => 'Assert a string does not end with another string.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
