<?php

namespace Concise\Mock;

class ClassCompiler
{
	protected $className;

	protected $mockUnique;

	protected $rules = [];

	public function __construct($className)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		$this->className = ltrim($className, '\\');
		$this->mockUnique = '_' . substr(md5(rand()), 24);
	}

	protected function getNamespaceName()
	{
		$parts = explode('\\', $this->className);
		array_pop($parts);
		return implode('\\', $parts);
	}

	protected function getClassName()
	{
		$parts = explode('\\', $this->className);
		return $parts[count($parts) - 1];
	}

	public function generateCode()
	{
		$refClass = new \ReflectionClass($this->className);

		$code = '';
		if($this->getNamespaceName()) {
			$code = "namespace " . $this->getNamespaceName() . "; ";
		}

		$methods = array();
		if($refClass->isAbstract()) {
			foreach($refClass->getMethods() as $method) {
				$methods[] = "public function " . $method->getName() . '() {}';
			}
		}

		foreach($this->rules as $method => $rule) {
			$action = $rule['action'];
			$methods[] = "public function " . $method . '() { ' . $action->getActionCode() . ' }';
			//$this->stubMethod($mock, $method, $action->getWillAction($this->testCase), $rule['times'], $rule['with']);
		}

		return $code . "class {$this->getMockName()} extends \\{$this->className} {" . implode(" ", $methods) . "}";
	}

	protected function getMockName()
	{
		return $this->getClassName() . $this->mockUnique;
	}

	public function newInstance()
	{
		return eval($this->generateCode() . " return new {$this->getMockName()}();");
	}

	public function setRules(array $rules)
	{
		$this->rules = $rules;
	}
}
