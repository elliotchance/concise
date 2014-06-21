<?php

namespace Concise\Matcher;

use \Concise\Services\ToStringConverter;

class StringEndsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? ends with ?' => 'Assert a string ends with another string.',
		);
	}

	public function match($syntax, array $data = array())
	{
		$converter = new ToStringConverter();
		$haystack = $converter->convertToString($data[0]);
		$needle = $converter->convertToString($data[1]);

		return ((substr($haystack, strlen($haystack) - strlen($needle)) === $needle));
	}
}
