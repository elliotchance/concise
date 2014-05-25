<?php

namespace Concise\Matcher;

class ThrowsException extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws exception',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			return false;
		}
		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			return true;
		}
		return false;
	}
}
