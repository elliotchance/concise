<?php

namespace Concise\Matcher;

class Boolean extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'false',
			'? is true',
			'? is false'
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === '? is true') {
			return $this->getComparer()->compare($data[0], true);
		}
		if($syntax === '? is false') {
			return $this->getComparer()->compare($data[0], false);
		}
		return false;
	}
}
