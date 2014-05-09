<?php

namespace Concise\Matcher;

class Equals extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? equals ?',
			'? is equal to ?'
		);
	}

	public function match($syntax, array $data = array())
	{
		return ($data[0] == $data[1]);
	}
}
