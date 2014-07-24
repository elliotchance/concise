<?php

namespace Concise\Mock;

use Concise\TestCase;

class MockBuilder
{
	/**
	 * @var Concise\TestCase
	 */
	protected $testCase;

	/**
	 * @var array
	 */
	protected $rules = array();

	/**
	 * @var bool
	 */
	protected $niceMock;

	/**
	 * The names of the methods to be mocked.
	 * @var array
	 */
	protected $mockedMethods = array();

	/**
	 * The original fully-qualified class name to create the mock from.
	 * @var string
	 */
	protected $className;

	/**
	 * Used internally as the active mocked method when using chained methods to builds the rules for this method.
	 * @var string
	 */
	protected $currentRule;

	/**
	 * Constructor arguments.
	 * @var array
	 */
	protected $constructorArgs;

	/**
	 * @param string   $className
	 * @param boolean  $niceMock
	 * @param TestCase $testCase
	 * @param array    $constructorArgs
	 */
	public function __construct(TestCase $testCase, $className, $niceMock, array $constructorArgs = array())
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
		$this->niceMock = $niceMock;
		$this->constructorArgs = $constructorArgs;
	}

	/**
	 * @param string                $method
	 * @param Action\AbstractAction $action
	 * @param integer               $times
	 */
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

	/**
	 * @param  array|string $arg
	 * @return MockBuilder
	 */
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

	/**
	 * Compiler the mock into a usable instance.
	 * @return object
	 */
	public function done()
	{
		$compiler = new ClassCompiler($this->className, $this->niceMock, $this->constructorArgs);
		$compiler->setRules($this->rules);
		$mockInstance = $compiler->newInstance();
		$this->testCase->addMockInstance($this, $mockInstance);
		return $mockInstance;
	}

	/**
	 * @return boolean
	 */
	protected function hasAction()
	{
		$action = $this->rules[$this->currentRule]['action'];
		if($action instanceof Action\ReturnValueAction && is_null($action->getValue())) {
			return false;
		}
		return true;
	}

	/**
	 * @param Action\AbstractAction $action
	 * @return MockBuilder
	 */
	protected function setAction(Action\AbstractAction $action)
	{
		if($this->hasAction()) {
			throw new \Exception("{$this->currentRule}() has more than one action attached.");
		}
		$this->rules[$this->currentRule]['action'] = $action;
		return $this;
	}

	/**
	 * @param  mixed $value
	 * @return MockBuilder
	 */
	public function andReturn($value)
	{
		return $this->setAction(new Action\ReturnValueAction($value));
	}

	/**
	 * @param \Exception $exception
	 * @return MockBuilder
	 */
	public function andThrow($exception)
	{
		return $this->setAction(new Action\ThrowAction($exception));
	}

	/**
	 * Expect the method to called called exactly once.
	 * @return MockBuilder
	 */
	public function once()
	{
		$this->exactly(1);
		return $this;
	}

	/**
	 * @param string $method
	 * @return MockBuilder
	 */
	public function expect($method)
	{
		$this->addRule($method, new Action\ReturnValueAction(null));
		$this->once();
		return $this;
	}

	/**
	 * @param string $method
	 * @return MockBuilder
	 */
	public function expects($method)
	{
		return $this->expect($method);
	}

	/**
	 * Expect the method to be called exactly twice.
	 * @return MockBuilder
	 */
	public function twice()
	{
		$this->exactly(2);
		return $this;
	}

	/**
	 * Expect that the method is never called.
	 * @return MockBuilder
	 */
	public function never()
	{
		$this->exactly(0);
		return $this;
	}

	/**
	 * @param integer $times
	 * @return MockBuilder
	 */
	public function exactly($times)
	{
		if($times === 0) {
			$this->andReturn(null);
		}
		$this->rules[$this->currentRule]['times'] = $times;
		return $this;
	}

	/**
	 * Expected arguments when invoking the mock.
	 * @return MockBuilder
	 */
	public function with()
	{
		$this->rules[$this->currentRule]['with'] = func_get_args();
		return $this;
	}

	/**
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}
}
