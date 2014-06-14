<?php

namespace Concise\Matcher;

class IsInstanceOf extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an instance of ?',
			'? is instance of ?',
			'? instance of ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_object($data[0])) {
			return false;
		}
		return (get_class($data[0]) === $data[1]) || is_subclass_of($data[0], $data[1]);
	}
}
