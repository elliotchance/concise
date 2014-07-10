<?php

namespace Concise\Mock;

class ClassCompiler
{
	public function __construct($className)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		if(strpos($className, '\\') !== false) {
			$parts = explode('\\', $className);
			$className = array_pop($parts);
			$this->code = "namespace " . implode('\\', $parts) . "; class {$className}Mock extends $className {}";
		}
		else {
			$this->code = "class {$className}Mock extends $className {}";
		}
	}

	public function generateCode()
	{
		return $this->code;
	}
}
