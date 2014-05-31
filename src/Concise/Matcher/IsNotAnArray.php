<?php

namespace Concise\Matcher;

class IsNotAnArray extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not an array',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !is_array($data[0]);
	}
}
