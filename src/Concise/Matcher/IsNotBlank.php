<?php

namespace Concise\Matcher;

class IsNotBlank extends IsBlank
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string is not blank' => 'Assert a string has at least one character.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}
}
