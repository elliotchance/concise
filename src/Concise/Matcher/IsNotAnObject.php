<?php

namespace Concise\Matcher;

class IsNotAnObject extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not an object',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !is_object($data[0]);
	}
}
