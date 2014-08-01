<?php

namespace Concise\Matcher;

class DoesNotContainStringIgnoringCase extends ContainsStringIgnoringCase
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string does not contain string ?:string ignoring case' => 'A string does not contain a substring (ignoring case-sensitivity)',
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
