<?php

namespace Concise\Matcher;

class Boolean extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'true',
			'false',
			'? is true',
			'? is false'
		);
	}

	public function match($syntax, array $data = array())
	{
		if($syntax === 'true') {
			return true;
		}
		if($syntax === 'false') {
			return false;
		}
		if($syntax === '? is true') {
			return ($data[0] === true);
		}
		if($syntax === '? is false') {
			return ($data[0] === false);
		}
	}
}
