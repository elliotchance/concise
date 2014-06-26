<?php

namespace Concise\Matcher;

class IsAnAssociativeArray extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:array is an associative array' => 'Assert an array is associative.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
