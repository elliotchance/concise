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

	protected $constructorArgs;

	/**
	 * @var boolean
	 */
	protected $disableConstructor = false;

	/**
	 * @param string $className
	 * @param boolean $niceMock
	 */
	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className, $niceMock, array $constructorArgs = array())
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
		$this->niceMock = $niceMock;
		$this->constructorArgs = $constructorArgs;
	}

	protected function addRule($method, Action\AbstractAction $action, $times = -1)
	{
		$this->currentRule = $method;
		$this->mockedMethods[] = $method;
		$this->rules[$method] = array(
			'action'      => $action,
			'times'       => $times,
			'with'        => null,
			'calledTimes' => 0,
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
			$this->addRule($arg, new Action\ReturnValueAction(null));
		}
		return $this;
	}

	public function done()
	{
		$compiler = new ClassCompiler($this->className, $this->niceMock, $this->constructorArgs, $this->disableConstructor);
		$compiler->setRules($this->rules);
		$mockInstance = $compiler->newInstance();
		$this->testCase->addMockInstance($this, $mockInstance);
		return $mockInstance;
	}

	protected function hasAction()
	{
		$action = $this->rules[$this->currentRule]['action'];
		if($action instanceof Action\ReturnValueAction && is_null($action->getValue())) {
			return false;
		}
		return true;
	}

	protected function setAction(Action\AbstractAction $action)
	{
		if($this->hasAction()) {
			throw new \Exception("{$this->currentRule}() has more than one action attached.");
		}
		$this->rules[$this->currentRule]['action'] = $action;
		return $this;
	}

	public function andReturn($value)
	{
		return $this->setAction(new Action\ReturnValueAction($value));
	}

	/**
	 * @param \Exception $exception
	 */
	public function andThrow($exception)
	{
		return $this->setAction(new Action\ThrowAction($exception));
	}

	public function once()
	{
		$this->exactly(1);
		return $this;
	}

	/**
	 * @param string $method
	 */
	public function expect($method)
	{
		$this->addRule($method, new Action\ReturnValueAction(null));
		$this->once();
		return $this;
	}

	/**
	 * @param string $method
	 */
	public function expects($method)
	{
		return $this->expect($method);
	}

	public function twice()
	{
		$this->exactly(2);
		return $this;
	}

	public function never()
	{
		$this->exactly(0);
		return $this;
	}

	/**
	 * @param integer $times
	 */
	public function exactly($times)
	{
		if($times === 0) {
			$this->andReturn(null);
		}
		$this->rules[$this->currentRule]['times'] = $times;
		return $this;
	}

	public function with()
	{
		$this->rules[$this->currentRule]['with'] = func_get_args();
		return $this;
	}

	public function getRules()
	{
		return $this->rules;
	}

	public function disableConstructor()
	{
		$this->disableConstructor = true;
		return $this;
	}
}
