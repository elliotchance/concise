<?php

namespace Concise\Mock;

class MockBuilder
{
	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	protected $rules = array();

	protected $niceMock;

	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className, $niceMock)
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
		$this->niceMock = $niceMock;
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

	protected function getAllMethodNamesForClass()
	{
		$class = new \ReflectionClass($this->className);
		$methodNames = array();
		foreach($class->getMethods() as $method) {
			$methodNames[] = $method->getName();
		}
		return $methodNames;
	}

	public function done()
	{
		$mockedMethods = array_keys($this->rules);
		$mock = $this->testCase->getMock($this->className, $mockedMethods);
		foreach($this->rules as $method => $value) {
			$mock->expects($this->testCase->any())
			     ->method($method)
			     ->will($this->testCase->returnValue($value));
		}

		// throw exception for remaining methods
		foreach($this->getAllMethodNamesForClass() as $method) {
			if(in_array($method, $mockedMethods)) {
				continue;
			}
			$mock->expects($this->testCase->any())
			     ->method($method)
			     ->will($this->testCase->throwException(new \Exception("$method() does not have an associated action - consider a niceMock()?")));
		}

		return $mock;
	}
}
