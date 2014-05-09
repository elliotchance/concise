<?php

namespace Concise\Matcher;

class Null extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? is null',
			'? is not null'
		);
	}

	public function match($syntax, array $data = array())
	{
		if('? is null' === $syntax) {
			return (null === $data[0]);
		}
		return (null !== $data[0]);
	}
}
