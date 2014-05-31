<?php

namespace Concise\Matcher;

class IsNull extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is null'
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_null($data[0]);
	}
}
