<?php

namespace Concise\Matcher;

class StringStartsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string starts with ?:string' => 'Assert a string starts (begins) with another string.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return ((substr($data[0], 0, strlen($data[1])) === $data[1]));
	}

	public function getTags()
	{
		return array(Tag::STRINGS);
	}
}
