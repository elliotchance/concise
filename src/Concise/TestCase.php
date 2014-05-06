<?php

namespace Concise;

class TestCase extends \PHPUnit_Framework_TestCase
{
	public function countConciseTests()
	{
		$class = new \ReflectionClass(get_class($this));
		$count = 0;
		foreach($class->getMethods() as $method) {
			if($this->isConciseTest($method->getName())) {
				++$count;
			}
		}
		return $count;
	}

	public function isConciseTest($method)
	{
		if(!is_string($method)) {
			throw new \InvalidArgumentException('$method must be a string.');
		}
		if($method == '') {
			throw new \InvalidArgumentException('$method can not be blank.');
		}
		return substr($method, 0, 5) === 'test_';
	}

	public function countAssertionsForMethod($method)
	{
		if(!$this->isConciseTest($method)) {
			return 0;
		}
		return 1;
	}
}
