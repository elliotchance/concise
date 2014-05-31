<?php

namespace Concise\Matcher;

class Boolean extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is true',
			'? is false'
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === '? is true') {
			return $this->getComparer()->compare($data[0], true);
		}
		return $this->getComparer()->compare($data[0], false);
	}
}
