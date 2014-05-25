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
			throw new \Exception("The attribute to test for exception must be callable (an anonymous function)");
		}
		$r = false;
		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			$r = (get_class($exception) === $data[1]) || is_subclass_of($exception, $data[1]);
		}
		
		if('? does not throw ?' === $syntax) {
			$r = !$r;
		}
		return $r;
	}
}
