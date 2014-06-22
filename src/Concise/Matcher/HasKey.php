<?php

namespace Concise\Matcher;

class HasKey extends AbstractMatcher
{
	const DESCRIPTION = 'Assert an array has key.';

	public function supportedSyntaxes()
	{
		return array(
			'?:array has key ?:string' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
