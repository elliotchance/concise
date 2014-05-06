<?php

namespace Concise;

class TestCase extends \PHPUnit_Framework_TestCase
{
	public function countConciseTests()
	{
		$assertions = $this->getAllAssertions();
		$count = 0;
		foreach($assertions as $a) {
			$count += count($a);
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
		$return = $this->$method();
		if($return === null || is_string($return)) {
			return 1;
		}
		if(is_array($return)) {
			foreach($return as $r) {
				if(!is_string($r)) {
					throw new \Exception("Test method '{$method}' returns an array that must contain only strings.");
				}
			}
			return count($return);
		}
		throw new \Exception("Test method '{$method}' must return void, string or an array of strings.");
	}

	public function convertMethodNameToAssertion($method)
	{
		$method = substr($method, 5);
		return str_replace('_', ' ', $method);
	}

	public function getAssertionsForMethod($method)
	{
		$return = $this->$method();
		if($return === null) {
			return array($this->convertMethodNameToAssertion($method));
		}
		if(is_array($return)) {
			return $return;
		}
		return array($return);
	}

	public function getAllAssertions()
	{
		$class = new \ReflectionClass(get_class($this));
		$assertions = array();
		foreach($class->getMethods() as $method) {
			$methodName = $method->getName();
			if($this->isConciseTest($methodName)) {
				$assertions[$methodName] = $this->getAssertionsForMethod($methodName);
			}
		}
		return $assertions;
	}
}
