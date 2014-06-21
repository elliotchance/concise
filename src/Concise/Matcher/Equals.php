<?php

namespace Concise\Matcher;

use \Concise\Syntax\ConvertToString;

class Equals extends AbstractMatcher
{
	const EQUALS_DESCRIPTION = 'Assert values with no regard to exact data types.';

	public function supportedSyntaxes()
	{
		return array(
			'? equals ?' => self::EQUALS_DESCRIPTION,
			'? is equal to ?' => self::EQUALS_DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return $this->getComparer()->compare($data[0], $data[1]);
	}
}
