<?php

namespace Concise\Mock;

class PrototypeBuilder
{
	public function getPrototype(\ReflectionMethod $method)
	{
		return 'public function testPrototypeIsBuiltFromReflectionMethod()';
	}
}