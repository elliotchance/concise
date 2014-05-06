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
		if(!is_string($method)) {
			throw new \InvalidArgumentException('$method must be a string.');
		}
		if($method == '') {
			throw new \InvalidArgumentException('$method can not be blank.');
		}
		return $method[0] === '_';
	}
}
