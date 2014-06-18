<?php

namespace Concise\Matcher;

class IsAnInteger extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an int' => 'Check value is strictly an integer type.',
			'? is an integer' => 'Check value is strictly an integer type.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_int($data[0]);
	}
}
