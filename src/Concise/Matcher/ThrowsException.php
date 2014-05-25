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
			throw new \Exception("The attribute to test for exception must be callable (an anonymous function)");
		}
		$r = false;
		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			$r = true;
		}
		
		if('? does not throw exception' === $syntax) {
			$r = !$r;
		}
		return $r;
	}
}
