<?php

namespace Concise\Mock;

class ClassCompiler
{
	protected $className;

	public function __construct($className)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		$this->className = $className;
	}

	public function generateCode()
	{
		if(strpos($this->className, '\\') !== false) {
			$parts = explode('\\', $this->className);
			$this->className = array_pop($parts);
			return "namespace " . implode('\\', $parts) . "; class {$this->getMockName()} extends {$this->className} {}";
		}

		return "class {$this->getMockName()} extends {$this->className} {}";
	}

	protected function getMockName()
	{
		return $this->className . 'Mock';
	}

	public function newInstance()
	{
		return eval($this->generateCode() . " return new {$this->getMockName()}();");
	}
}
