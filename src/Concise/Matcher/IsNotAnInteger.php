<?php

namespace Concise\Matcher;

class IsNotAnInteger extends IsAnInteger
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not an int',
			'? is not an integer',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
