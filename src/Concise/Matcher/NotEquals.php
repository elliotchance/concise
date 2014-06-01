<?php

namespace Concise\Matcher;

class NotEquals extends Equals
{
	public function supportedSyntaxes()
	{
		return array(
			'? not equals ?',
			'? is not equal to ?',
			'? does not equal ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}
}
