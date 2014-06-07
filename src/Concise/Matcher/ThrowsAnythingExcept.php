<?php

namespace Concise\Matcher;

class ThrowsAnythingExcept extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws anything except ?',
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
			$exceptionClass = get_class($exception);
			if($exceptionClass === $data[1]) {
				throw new DidNotMatchException("Expected any exception except {$data[1]} to be thrown, but $exceptionClass was thrown.");
			}
			return false;
		}
		return true;
	}
}
