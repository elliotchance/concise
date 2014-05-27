<?php

namespace Concise\Matcher;

class ThrowsExactly extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws exactly ?',
			'? anything except ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			throw new DidNotMatchException("The attribute to test for exception must be callable (an anonymous function)");
		}

		if('? throws exactly ?' === $syntax) {
			try {
				$data[0]();
			}
			catch(\Exception $exception) {
				$exceptionClass = get_class($exception);
				if($exceptionClass !== $data[1]) {
					throw new DidNotMatchException("Expected exactly {$data[1]} to be thrown, but $exceptionClass was thrown.");
				}
				return true;
			}
			throw new DidNotMatchException("Expected exactly {$data[1]} to be thrown, but nothing was thrown.");
		}

		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			$exceptionClass = get_class($exception);
			if($exceptionClass === $data[1]) {
				throw new DidNotMatchException("Expected exactly {$data[1]} to be thrown, but $exceptionClass was thrown.");
			}
			return false;
		}
		return true;
	}
}
