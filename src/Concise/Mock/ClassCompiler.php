<?php

namespace Concise\Mock;

class ClassCompiler
{
	public function __construct($className)
	{
		$this->code = "class {$className}Mock extends $className {}";
	}

	public function generateCode()
	{
		return $this->code;
	}
}
