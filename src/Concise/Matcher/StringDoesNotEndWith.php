<?php

namespace Concise\Matcher;

use \Concise\Services\ConvertToString;

class StringDoesNotEndWith extends StringEndsWith
{
	public function supportedSyntaxes()
	{
		return array(
			'? does not end with ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
