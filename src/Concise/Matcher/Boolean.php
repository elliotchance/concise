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
			return AbstractMatcher::SUCCESS;
		}
		if($syntax === 'false') {
			return "Failed";
		}
		if($syntax === '? is true') {
			return ($data[0] === true ? AbstractMatcher::SUCCESS : 'Value is not true.');
		}
		if($syntax === '? is false') {
			return ($data[0] === false ? AbstractMatcher::SUCCESS : 'Value is not false.');
		}
	}
}
