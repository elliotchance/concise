<?php

namespace Concise\Mock;

class ClassCompiler
{
	/**
	 * The fully qualified class name.
	 * @var string
	 */
	protected $className;

	/**
	 * A unique string to be appended to the mock class name to make it unique (separate it from other mocks with the
	 * same name)
	 * @var string
	 */
	protected $mockUnique;

	/**
	 * The rules for the methods.
	 * @var array
	 */
	protected $rules = array();

	/**
	 * If this is a nice mock.
	 * @var bool
	 */
	protected $niceMock;

	/**
	 * Arguments to pass to the constructor for the mock.
	 * @var array
	 */
	protected $constructorArgs;

	/**
	 * @var boolean
	 */
	protected $disableConstructor;

	/**
	 * @var string[]
	 */
	protected $expose = array();

	/*
	 * @param string  $className
	 * @param boolean $niceMock
	 * @param array   $constructorArgs
	 */
	public function __construct($className, $niceMock = false, array $constructorArgs = array(), $disableConstructor = false)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		$this->className = ltrim($className, '\\');
		$this->mockUnique = '_' . substr(md5(rand()), 24);
		$this->niceMock = $niceMock;
		$this->constructorArgs = $constructorArgs;
		$this->disableConstructor = $disableConstructor;
	}

	/**
	 * Get the namespace for the mocked class.
	 * @return string
	 */
	protected function getNamespaceName()
	{
		$parts = explode('\\', $this->className);
		array_pop($parts);
		return implode('\\', $parts);
	}

	/**
	 * Get the class name (not including the namespace) of the class to be mocked.
	 * @return string
	 */
	protected function getClassName()
	{
		$parts = explode('\\', $this->className);
		return $parts[count($parts) - 1];
	}

	protected function getPrototype($method)
	{
		$prototypeBuilder = new PrototypeBuilder();
		$prototypeBuilder->hideAbstract = true;
		$realMethod = new \ReflectionMethod($this->className, $method);
		$prototype = $prototypeBuilder->getPrototype($realMethod);
		if(array_key_exists($method, $this->expose)) {
			$prototype = str_replace('protected ', 'public ', $prototype);
		}
		return $prototype;
	}

	/**
	 * Generate the PHP code for the mocked class.
	 * @return string
	 */
	public function generateCode()
	{
		$refClass = new \ReflectionClass($this->className);
		if($refClass->isFinal()) {
			throw new \Exception("Class {$this->className} is final so it cannot be mocked.");
		}

		$code = '';
		if($this->getNamespaceName()) {
			$code = "namespace " . $this->getNamespaceName() . "; ";
		}

		$methods = array();
		if(!$this->niceMock) {
			foreach($refClass->getMethods() as $method) {
				if($method->isFinal()) {
					continue;
				}
				$prototype = $this->getPrototype($method->getName());
				$methods[$method->getName()] = $prototype . ' { throw new \\Exception("' . $method->getName() .
					'() does not have an associated action - consider a niceMock()?"); }';
			}
		}

		foreach($this->rules as $method => $rule) {
			$action = $rule['action'];
			$realMethod = new \ReflectionMethod($this->className, $method);
			if($realMethod->isFinal()) {
				throw new \Exception("Method {$this->className}::{$method}() is final so it cannot be mocked.");
			}
			if($realMethod->isPrivate()) {
				throw new \Exception("Method '{$method}' cannot be mocked becuase it it private.");
			}
			$prototype = $this->getPrototype($method);
			$methods[$method] = "$prototype { if(!array_key_exists('$method', self::\$_methodCalls)) { self::\$_methodCalls['$method'] = array(); } self::\$_methodCalls['$method'][] = func_get_args(); " . $action->getActionCode() . ' }';
		}

		if($this->disableConstructor) {
			$methods['__construct'] = 'public function __construct() {}';
		}
		else {
			unset($methods['__construct']);
		}
		$methods['getCallsForMethod'] = 'public function getCallsForMethod($method) { return array_key_exists($method, self::$_methodCalls) ? self::$_methodCalls[$method] : array(); }';

		foreach($this->expose as $method => $value) {
			if(!array_key_exists($method, $methods)) {
				$prototype = $this->getPrototype($method);
				$methods[$method] = "$prototype { return call_user_func_array(\"parent::{$method}\", func_get_args()); }";
			}
		}

		return $code . "class {$this->getMockName()} extends \\{$this->className} { public static \$_methodCalls = array(); " . implode(" ", $methods) . "}";
	}

	/**
	 * Get the name of the mocked class (not including the namespace).
	 * @return string
	 */
	protected function getMockName()
	{
		return $this->getClassName() . $this->mockUnique;
	}

	/**
	 * Create a new instance of the mocked class. There is no need to generate the code before invoking this.
	 * @return object
	 */
	public function newInstance()
	{
		$reflect = eval($this->generateCode() . " return new \\ReflectionClass('{$this->getNamespaceName()}\\{$this->getMockName()}');");
		return $reflect->newInstanceArgs($this->constructorArgs);
	}

	/**
	 * Set all the rules for the mock.
	 * @param array $rules
	 */
	public function setRules(array $rules)
	{
		$this->rules = $rules;
	}

	/**
	 * @param string $method
	 */
	public function addExpose($method)
	{
		try {
			$m = new \ReflectionMethod($this->className, $method);
			if($m->isPrivate()) {
				throw new \InvalidArgumentException("Method '{$this->className}::$method' is private and cannot be exposed.");
			}
		}
		catch(\ReflectionException $e) {
			throw new \InvalidArgumentException("Method '{$this->className}::$method' does not exist.");
		}
		$this->expose[$method] = true;
	}
}
