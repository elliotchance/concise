<?php

namespace Concise\Matcher;

use \Concise\Services\ConvertToString;

class StringDoesNotStartWith extends StringStartsWith
{
	public function supportedSyntaxes()
	{
		// @test this is allowed to return a single string
		return array(
			'? does not start with ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
