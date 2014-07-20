<?php

namespace Concise\Matcher;

class IsNotInstanceOf extends IsInstanceOf
{
	const DESCRIPTION = 'Assert than an object is not a class or subclass.';

	public function supportedSyntaxes()
	{
		return array(
			'?:object is not an instance of ?:class' => self::DESCRIPTION,
			'?:object is not instance of ?:class' => self::DESCRIPTION,
			'?:object not instance of ?:class' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}

	public function getTags()
	{
		return array(Tag::BASIC, Tag::OBJECTS);
	}
}
