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
		// @test messages returned have no tests
		if('? is null' === $syntax) {
			return (null === $data[0]) ? AbstractMatcher::SUCCESS : 'expected null';
		}
		return (null !== $data[0]) ? AbstractMatcher::SUCCESS : 'expected not null';
	}
}
