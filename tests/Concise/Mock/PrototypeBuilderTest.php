<?php

namespace Concise\Mock;

use \Concise\TestCase;

class PrototypeBuilderTest extends TestCase
{
	public function testPrototypeIsBuiltFromReflectionMethod()
	{
		$method = new \ReflectionMethod('\Concise\Mock\PrototypeBuilderTest', 'testPrototypeIsBuiltFromReflectionMethod');
		$builder = new PrototypeBuilder();
		$this->assert($builder->getPrototype($method), equals, 'public function testPrototypeIsBuiltFromReflectionMethod()');
	}
}
