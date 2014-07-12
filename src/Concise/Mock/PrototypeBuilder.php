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
			$param = '$' . $p->getName();
			if($p->getClass()) {
				$param = '\\' . $p->getClass()->name . ' ' . $param;
			}
			if($p->isOptional()) {
				$param .= ' = ' . $p->getDefaultValue();
			}
			$parameters[] = $param;
		}
		return $modifiers . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
	}
}
