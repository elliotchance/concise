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

	protected function addRule($method, Action\AbstractAction $action, $times = -1)
	{
		$this->currentRule = $method;
		$this->mockedMethods[] = $method;
		$this->rules[$method] = array(
			'action' => $action,
			'times' => $times,
		);
	}

	public function stub($arg)
	{
		if(is_array($arg)) {
			if(count($arg) === 0) {
				throw new \Exception("stub() called with array must have at least 1 element.");
			}
			foreach($arg as $method => $value) {
				$this->addRule($method, new Action\ReturnValueAction($value));
			}
		}
		else {
			$this->addRule($arg, new Action\NoAction());
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

	protected function stubMethod($mock, $method, $will, $times = -1)
	{
		$expect = $this->testCase->any();
		if($times >= 0) {
			$expect = $this->testCase->exactly($times);
		}
		$mock->expects($expect)
			 ->method($method)
			 ->will($will);
	}

	public function done()
	{
		$this->validate();

		$class = $this->className;
		$originalObject = new $class();

		//var_dump($this->rules);

		$allMethods = array_unique($this->getAllMethodNamesForClass() + array_keys($this->rules));
		$mock = $this->testCase->getMock($this->className, $allMethods);
		foreach($this->rules as $method => $rule) {
			$action = $rule['action'];
			$this->stubMethod($mock, $method, $action->getWillAction($this->testCase), $rule['times']);
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
		$this->rules[$this->currentRule]['action'] = new Action\ReturnValueAction($value);
		return $this;
	}

	protected function validate()
	{
		foreach($this->rules as $method => $rule) {
			if($rule['action'] instanceof Action\NoAction) {
				throw new \Exception("$method() does not have an associated action - did you forget andReturn()?");
			}
		}
	}

	public function andThrow($exception)
	{
		$this->rules[$this->currentRule]['action'] = new Action\ThrowAction($exception);
		return $this;
	}

	public function once()
	{
		$this->rules[$this->currentRule]['times'] = 1;
		return $this;
	}

	public function expect($method)
	{
		$this->addRule($method, new Action\NoAction());
		return $this;
	}

	public function twice()
	{
		$this->rules[$this->currentRule]['times'] = 2;
		return $this;
	}
}
