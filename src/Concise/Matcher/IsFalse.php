<?php

namespace Concise\Matcher;

class IsFalse extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is false' => 'Check for boolean false.'
		);
	}

	public function match($syntax, array $data = array())
	{
		return $this->getComparer()->compare($data[0], false);
	}
}
