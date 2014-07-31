<?php

namespace Concise\Matcher;

class DoesNotContainString extends ContainsString
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string does not contain string ?:string' => 'A string does not contain a substring.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}

	public function getTags()
	{
		return array(Tag::STRINGS);
	}
}
