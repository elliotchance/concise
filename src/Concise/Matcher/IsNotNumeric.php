<?php

namespace Concise\Matcher;

class IsNotNumeric extends IsNumeric
{
	public function supportedSyntaxes()
	{
		return array(
			'? is not numeric' => 'Assert value is not a number or string that represents a number.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match(null, $data);
	}

	public function getTags()
	{
		return array(Tag::BASIC, Tag::NUMBERS);
	}
}
