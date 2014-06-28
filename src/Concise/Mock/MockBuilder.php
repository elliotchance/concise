<?php

namespace Concise\Mock;

class MockBuilder
{
	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	protected $rules = array();

	protected $niceMock;

	protected $mockedMethods = array();

	protected $className;

	protected $currentRule;

	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className, $niceMock)
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
		$this->niceMock = $niceMock;
	}

	protected function addRule($method, $value)
	{
		$this->currentRule = $method;
		$this->mockedMethods[] = $method;
		$this->rules[$method] = $value;
	}

	public function stub($arg)
	{
		if(is_array($arg)) {
			if(count($arg) === 0) {
				throw new \Exception("stub() called with array must have at least 1 element.");
			}
			foreach($arg as $method => $value) {
				$this->addRule($method, $value);
			}
		}
		else {
			$this->addRule($arg, null);
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

	protected function stubMethod($mock, $method, $will)
	{
		$mock->expects($this->testCase->any())
			 ->method($method)
			 ->will($will);
	}

	public function done()
	{
		$this->validate();

		$class = $this->className;
		$originalObject = new $class();

		$allMethods = array_unique($this->getAllMethodNamesForClass() + array_keys($this->rules));
		$mock = $this->testCase->getMock($this->className, $allMethods);
		foreach($this->rules as $method => $value) {
			$this->stubMethod($mock, $method, $this->testCase->returnValue($value));
		}

		// throw exception for remaining methods
		if($this->niceMock) {
			foreach($allMethods as $method) {
				if(in_array($method, $this->mockedMethods)) {
					continue;
				}
				$will = $this->testCase->returnCallback(array($originalObject, $method));
				$this->stubMethod($mock, $method, $will);
			}
		}
		else {
			foreach($allMethods as $method) {
				if(in_array($method, $this->mockedMethods)) {
					continue;
				}
				$will = $this->testCase->throwException(new \Exception("$method() does not have an associated action - consider a niceMock()?"));
				$this->stubMethod($mock, $method, $will);
			}
		}

		return $mock;
	}

	public function andReturn($value)
	{
		$this->rules[$this->currentRule] = $value;
		return $this;
	}

	protected function validate()
	{
		foreach($this->rules as $method => $value) {
			if(is_null($value)) {
				throw new \Exception("$method() does not have an associated action - did you forget andReturn()?");
			}
		}
	}
}
