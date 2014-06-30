<?php

namespace Concise\Services;

class AssertionBuilder
{
	public function __construct(array $args)
	{
	}

	public function getAssertion()
	{
		return new \Concise\Matcher\Equals();
	}
}
