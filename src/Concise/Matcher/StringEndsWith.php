<?php

namespace Concise\Matcher;

use \Concise\Services\ConvertToString;

class StringEndsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? ends with ?',
			'? does not end with ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		$converter = new ConvertToString();
		$haystack = $converter->convertToString($data[0]);
		$needle = $converter->convertToString($data[1]);

		$match = (substr($haystack, strlen($haystack) - strlen($needle)) === $needle);

		if($syntax === '? does not end with ?') {
			$match = !$match;
		}
		return $match;
	}
}
