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

	public function stub(array $stubs)
	{
		if(count($stubs) === 0) {
			throw new \Exception("stub() called with array must have at least 1 element.");
		}
		foreach($stubs as $method => $value) {
			$this->rules[$method] = $value;
		}
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
