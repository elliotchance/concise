<?php

namespace Concise\Matcher;

class ContainsString extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string contains string ?:string' => 'A string contains a substring',
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}

	public function getTags()
	{
		return array(Tag::STRINGS);
	}
}
