<?php

namespace Concise\Matcher;

class NotEquals extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? not equals ?',
			'? is not equal to ?',
			'? does not equal ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !$this->getComparer()->compare($data[0], $data[1]);
	}
}
