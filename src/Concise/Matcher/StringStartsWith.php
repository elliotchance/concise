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
		return substr($data[0], 0, strlen($data[1])) == $data[1];
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
