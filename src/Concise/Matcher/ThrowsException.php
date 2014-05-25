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
			throw new \Exception("The attribute to test for exception must be callable (an anonymous function)");
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
