<?php

namespace Concise\Mock;

class PrototypeBuilder
{
	public function getPrototype(\ReflectionMethod $method)
	{
		$modifiers = \Reflection::getModifierNames($method->getModifiers());
		return implode(' ', $modifiers) . ' function ' . $method->getName() . '()';
	}
}
