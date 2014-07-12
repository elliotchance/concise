<?php

namespace Concise\Mock;

class PrototypeBuilder
{
	public function getPrototype(\ReflectionMethod $method)
	{
		$modifiers = \Reflection::getModifierNames($method->getModifiers());
		$parameters = array();
		foreach($method->getParameters() as $p) {
			$parameters[] = '$' . $p->getName();
		}
		return implode(' ', $modifiers) . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
	}
}
