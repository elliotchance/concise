<?php

namespace Concise\Matcher;

class IsNotAString extends IsAString
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not a string',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
