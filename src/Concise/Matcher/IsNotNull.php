<?php

namespace Concise\Matcher;

class IsNotNull extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not null',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !is_null($data[0]);
	}
}
