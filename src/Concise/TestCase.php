<?php

namespace Concise;

class TestCase extends \PHPUnit_Framework_TestCase
{
	public function countConciseTests()
	{
		return 2;
	}

	public function isConciseTest($method)
	{
		return $method[0] === '_';
	}
}
