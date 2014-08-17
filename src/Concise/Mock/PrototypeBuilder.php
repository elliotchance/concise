<?php

namespace Concise\Mock;

class PrototypeBuilder
{
    /**
	 * If this is `true` then the `abstract` keyword will not be outputted in the prototypes.
	 * @var boolean
	 */
    public $hideAbstract = false;

    protected function getDefaultValue(\ReflectionParameter $p)
    {
        if ($p->isOptional()) {
            try {
                return ' = ' . var_export($p->getDefaultValue(), true);
            } catch (\ReflectionException $e) {
                return ' = NULL';
            }
        }
    }

    protected function getTypeHint(\ReflectionParameter $p)
    {
        if ($p->getClass()) {
            return '\\' . $p->getClass()->name . ' ';
        } elseif ($p->isArray()) {
            return 'array ';
        } elseif (method_exists($p, 'isCallable') && $p->isCallable()) {
            return 'callable ';
        }
        return '';
    }

    protected function getName(\ReflectionParameter $p)
    {
        $param = '$' . $p->getName();
        if ($p->isPassedbyReference()) {
            $param = '&' . $param;
        }
        return $param;
    }

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
            $param = $this->getTypeHint($p);
            $param .= $this->getName($p);
            $param .= $this->getDefaultValue($p);
            $parameters[] = $param;
        }

        return $modifiers . ' function ' . $method->getName() . "(" . implode(', ', $parameters) . ")";
    }

    public function getPrototypeForNonExistantMethod($method)
    {
        return "public function $method()";
    }
}
