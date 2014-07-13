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
			if($p->isPassedbyReference()) {
				$param = '&' . $param;
			}
			if($p->getClass()) {
				$param = '\\' . $p->getClass()->name . ' ' . $param;
			}
			if($p->isOptional()) {
				try {
					$param .= ' = ' . $p->getDefaultValue();
				}
				catch(\ReflectionException $e) {
					// The default value cannot be determined for internal methods.
				}
			}
			$parameters[] = $param;
		}
		return $modifiers . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
	}
}
