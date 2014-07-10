<?php

namespace Concise\Mock;

use \Concise\TestCase;

class ClassCompilerTest extends TestCase
{
	public function testPHPCodeIsGeneratedWithTheClassName()
	{
		$compiler = new ClassCompiler('MyClass');
		$this->assert($compiler->generateCode(), equals, "class MyClassMock extends MyClass {}");
	}
}
