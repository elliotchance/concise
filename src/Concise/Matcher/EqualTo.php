<?php

namespace Concise\Matcher;

class EqualTo extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? equals ?',
			'? is equal to ?'
		);
	}

	public function match($syntax, array $data = array())
	{
		if($data[0] == $data[1]) {
			return AbstractMatcher::SUCCESS;
		}
		// @todo fix this and write a test
		return 'bad';
	}
}
