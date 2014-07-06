<?php

namespace Concise\Matcher;

class IsLessThan extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:number is less than ?:number' => 'A number is less than another number.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return $data[0] < $data[1];
	}
}
