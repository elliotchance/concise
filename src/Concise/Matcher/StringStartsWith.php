<?php

namespace Concise\Matcher;

use \Concise\Services\ConvertToString;

class StringStartsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? starts with ?',
			'? does not start with ?'
		);
	}

	public function match($syntax, array $data = array())
	{
		$converter = new ConvertToString();
		$haystack = $converter->convertToString($data[0]);
		$needle = $converter->convertToString($data[1]);

		$match = (substr($haystack, 0, strlen($needle)) === $needle);
		if($syntax === '? does not start with ?') {
			$match = !$match;
		}
		return $match;
	}
}
