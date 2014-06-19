<?php

namespace Concise\Matcher;

class IsTrue extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is true' => 'Assert a value is true.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return $this->getComparer()->compare($data[0], true);
	}
}
