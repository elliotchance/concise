<?php

namespace Concise\Matcher;

class ThrowsException extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws exception',
			'? does not throw exception',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			throw new DidNotMatchException("The attribute to test for exception must be callable (an anonymous function)");
		}

		if('? throws exception' === $syntax) {
			try {
				$data[0]();
			}
			catch(\Exception $exception) {
				return true;
			}
			throw new DidNotMatchException("Expected exception to be thrown.");
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
