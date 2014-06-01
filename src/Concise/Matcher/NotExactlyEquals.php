<?php

namespace Concise\Matcher;

class NotExactlyEquals extends ExactlyEquals
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not exactly equal to ?',
			'? does not exactly equal ?',
			'? is not the same as ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
