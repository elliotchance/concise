<?php

namespace Concise\Matcher;

class Null extends AbstractMatcher
{
	public function matchesSyntax($syntax)
	{
		return in_array($syntax, array('? is null', '? is not null'));
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
