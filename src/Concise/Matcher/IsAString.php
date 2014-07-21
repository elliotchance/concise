<?php

namespace Concise\Matcher;

class IsAString extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is a string' => 'Assert value is a string.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return is_string($data[0]);
	}

	public function getTags()
	{
		return array(Tag::STRINGS);
	}
}
