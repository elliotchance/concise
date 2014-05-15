<?php

namespace Concise\Matcher;

class IsObject extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is an object',
			'? is not an object',
		);
	}

	public function match($syntax, array $data = array())
	{
		$object = is_object($data[0]);
		if('? is an object' === $syntax) {
			return $object;
		}
		return !$object;
	}
}
