<?php

namespace Concise\Matcher;

class True extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'true',
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
