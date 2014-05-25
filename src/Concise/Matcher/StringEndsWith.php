<?php

namespace Concise\Matcher;

class StringEndsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? ends with ?',
			'? does not end with ?'
		);
	}

	protected function performMatch(array $data = array())
	{
		$haystack = (string) $data[0];
		$needle = (string) $data[1];
		return substr($haystack, strlen($haystack) - strlen($needle)) == $needle;
	}

	public function match($syntax, array $data = array())
	{
		$match = $this->performMatch($data);
		if($syntax === '? does not end with ?') {
			$match = !$match;
		}
		return $match;
	}
}
