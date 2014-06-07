<?php

namespace Concise\Matcher;

class True extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'true' => 'Always pass.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
