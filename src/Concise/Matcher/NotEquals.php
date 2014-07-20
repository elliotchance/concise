<?php

namespace Concise\Matcher;

class NotEquals extends Equals
{
	const DESCRIPTION = 'Assert two value do not match with no regard to type.';

	public function supportedSyntaxes()
	{
		return array(
			'? not equals ?' => self::DESCRIPTION,
			'? is not equal to ?' => self::DESCRIPTION,
			'? does not equal ?' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match($syntax, $data);
	}

	public function getTags()
	{
		return array(Tag::BASIC);
	}
}
