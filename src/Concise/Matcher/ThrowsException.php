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
			throw new DidNotMatchException("The attribute to test for exception must be callable (an anonymous function)");
		}

		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			return true;
		}
		throw new DidNotMatchException("Expected exception to be thrown.");
	}
}
