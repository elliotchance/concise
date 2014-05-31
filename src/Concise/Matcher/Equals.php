<?php

namespace Concise\Matcher;

use \Concise\Syntax\ConvertToString;

class Equals extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? equals ?',
			'? is equal to ?'
		);
	}

	public function match($syntax, array $data = array())
	{
		return $this->getComparer()->compare($data[0], $data[1]);
	}
}
