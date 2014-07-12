<?php

namespace Concise\Mock;

class PrototypeBuilder
{
	public $hideAbstract = false;

	public function getPrototype(\ReflectionMethod $method)
	{
		$modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
		if($this->hideAbstract) {
			$modifiers = str_replace('abstract ', '', $modifiers);
		}
		$parameters = array();
		foreach($method->getParameters() as $p) {
			$parameters[] = '$' . $p->getName();
		}
		return $modifiers . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
	}
}
