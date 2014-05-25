<?php

namespace Concise\Matcher;

class StringStartsWith extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? starts with ?',
			'? does not start with ?'
		);
	}

	protected function performMatch(array $data = array())
	{
		$haystack = (string) $data[0];
		$needle = (string) $data[1];
		return substr($haystack, 0, strlen($needle)) == $needle;
	}

	public function match($syntax, array $data = array())
	{
		$match = $this->performMatch($data);
		if($syntax === '? does not start with ?') {
			$match = !$match;
		}
		return $match;
	}
}
