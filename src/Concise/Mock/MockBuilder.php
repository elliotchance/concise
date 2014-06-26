<?php

namespace Concise\Mock;

class MockBuilder
{
	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	protected $rules = array();

	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className)
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
	}

	public function stub($pair)
	{
		$method = current(array_keys($pair));
		$value = current(array_values($pair));
		$this->rules[$method] = $value;
		return $this;
	}

	public function done()
	{
		$mock = $this->testCase->getMock($this->className, array_keys($this->rules));
		foreach($this->rules as $method => $value) {
			$mock->expects($this->testCase->any())
			     ->method($method)
			     ->will($this->testCase->returnValue($value));
		}
		return $mock;
	}
}
