<?php

namespace Concise\Matcher;

class ExactlyEquals extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is exactly equal to ?',
			'? exactly equals ?',
			'? is the same as ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return ($data[0] === $data[1]);
	}
}
