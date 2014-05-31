<?php

namespace Concise\Matcher;

class False extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'false',
		);
	}

	public function match($syntax, array $data = array())
	{
		return false;
	}
}
