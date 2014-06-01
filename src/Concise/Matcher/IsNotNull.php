<?php

namespace Concise\Matcher;

class IsNotNull extends IsNull
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not null',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
