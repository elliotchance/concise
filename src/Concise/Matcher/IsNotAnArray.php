<?php

namespace Concise\Matcher;

class IsNotAnArray extends IsAnArray
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not an array' => 'Assert a value is not an array.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
