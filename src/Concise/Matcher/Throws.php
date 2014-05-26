<?php

namespace Concise\Matcher;

class Throws extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws ?',
			'? does not throw ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			throw new DidNotMatchException("The attribute to test for exception must be callable (an anonymous function)");
		}

		if('? throws ?' === $syntax) {
			try {
				$data[0]();
			}
			catch(\Exception $exception) {
				$exceptionClass = get_class($exception);
				$matchesOrIsSubclassOf = ($exceptionClass === $data[1]) || is_subclass_of($exception, $data[1]);
				if(!$matchesOrIsSubclassOf) {
					throw new DidNotMatchException("Expected {$data[1]} to be thrown, but $exceptionClass was thrown.");
				}
				return true;
			}
			throw new DidNotMatchException("Expected {$data[1]} to be thrown, but nothing was thrown.");
		}

		if('? does not throw ?' === $syntax) {
			try {
				$data[0]();
			}
			catch(\Exception $exception) {
				$exceptionClass = get_class($exception);
				$matchesOrIsSubclassOf = ($exceptionClass === $data[1]) || is_subclass_of($exception, $data[1]);
				if($matchesOrIsSubclassOf) {
					throw new DidNotMatchException("Expected {$data[1]} to be thrown, but $exceptionClass was thrown.");
				}
			}
			return true;
		}

		return true;
	}
}
