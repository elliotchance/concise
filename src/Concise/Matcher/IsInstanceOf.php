<?php

namespace Concise\Matcher;

class IsInstanceOf extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an objects class or subclass.';

	public function supportedSyntaxes()
	{
		return array(
			'?:object is an instance of ?:class' => self::DESCRIPTION,
			'?:object is instance of ?:class' => self::DESCRIPTION,
			'?:object instance of ?:class' => self::DESCRIPTION,
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
