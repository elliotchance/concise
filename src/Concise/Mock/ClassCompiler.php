<?php

namespace Concise\Mock;

class ClassCompiler
{
	public function __construct($className)
	{
		if(!class_exists($className)) {
			throw new \Exception("The class '$className' is not loaded so it cannot be mocked.");
		}
		$this->code = "class {$className}Mock extends $className {}";
	}

	public function generateCode()
	{
		return $this->code;
	}
}
