<?php

namespace Concise\Mock;

class ClassCompiler
{
	protected $className;

	protected $mockUnique;

	public function __construct($className)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		$this->className = ltrim($className, '\\');
	}

	public function generateCode()
	{
		$refClass = new \ReflectionClass($this->className);
		$this->mockUnique = '_' . substr(md5(rand()), 24);

		$code = '';
		if(strpos($this->className, '\\') !== false) {
			$parts = explode('\\', $this->className);
			$this->className = array_pop($parts);
			$code = "namespace " . implode('\\', $parts) . "; ";
		}

		$methods = array();
		if($refClass->isAbstract()) {
			foreach($refClass->getMethods() as $method) {
				$methods[] = "public function " . $method->getName() . '() {}';
			}
		}

		return $code . "class {$this->getMockName()} extends {$this->className} {" . implode(" ", $methods) . "}";
	}

	protected function getMockName()
	{
		return $this->className . $this->mockUnique;
	}

	public function newInstance()
	{
		return eval($this->generateCode() . " return new {$this->getMockName()}();");
	}
}
