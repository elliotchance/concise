<?php

namespace Concise\Matcher;

class StringStartsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? starts with ?'
		);
	}

	public function match($syntax, array $data = array())
	{
		return substr($data[0], 0, strlen($data[1])) == $data[1];
	}
}
