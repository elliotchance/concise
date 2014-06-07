<?php

namespace Concise\Matcher;

class Throws extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws ?',
		);
	}

	/**
	 * @param callable $expectedClass
	 */
	protected function isKindOfClass(\Exception $exception, $expectedClass)
	{
		return (get_class($exception) === $expectedClass) || is_subclass_of($exception, $expectedClass);
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
			if($this->isKindOfClass($exception, $data[1])) {
				return true;
			}
			$exceptionClass = get_class($exception);
			throw new DidNotMatchException("Expected {$data[1]} to be thrown, but $exceptionClass was thrown.");
		}
		throw new DidNotMatchException("Expected {$data[1]} to be thrown, but nothing was thrown.");
	}
}
