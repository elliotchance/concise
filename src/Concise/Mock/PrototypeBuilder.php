<?php

namespace Concise\Mock;

class PrototypeBuilder
{
    /**
	 * If this is `true` then the `abstract` keyword will not be outputted in the prototypes.
	 * @var boolean
	 */
    public $hideAbstract = false;

    /**
	 * Get the prototype for the method.
	 * @param  \ReflectionMethod $method
	 * @return string
	 */
    public function getPrototype(\ReflectionMethod $method)
    {
        $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
        if ($this->hideAbstract) {
            $modifiers = str_replace('abstract ', '', $modifiers);
        }
        $parameters = array();
        foreach ($method->getParameters() as $p) {
            $param = '$' . $p->getName();
            if ($p->isPassedbyReference()) {
                $param = '&' . $param;
            }
            if ($p->getClass()) {
                $param = '\\' . $p->getClass()->name . ' ' . $param;
            } elseif ($p->isArray()) {
                $param = 'array ' . $param;
            } elseif (method_exists($p, 'isCallable') && $p->isCallable()) {
                $param = 'callable ' . $param;
            }
            if ($p->isOptional()) {
                try {
                    $param .= ' = ' . var_export($p->getDefaultValue(), true);
                } catch (\ReflectionException $e) {
                    $param .= ' = NULL';
                }
            }
            $parameters[] = $param;
        }

        return $modifiers . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
    }
}
