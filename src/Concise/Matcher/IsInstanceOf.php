<?php

namespace Concise\Matcher;

class IsInstanceOf extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:object is an instance of ?:class',
			'?:object is instance of ?:class',
			'?:object instance of ?:class',
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
