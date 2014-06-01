<?php

namespace Concise\Matcher;

class DoesNotThrowException extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? does not throw exception',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			throw new DidNotMatchException("The attribute to test for exception must be callable (an anonymous function)");
		}

		try {
			$data[0]();
			return true;
		}
		catch(\Exception $exception) {
			throw new DidNotMatchException("Expected exception not to be thrown.");
		}
	}
}
