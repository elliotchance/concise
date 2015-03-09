<?php

namespace Concise\Mock;

use Reflection;
use ReflectionParameter;
use ReflectionMethod;
use Concise\Validation\ArgumentChecker;

class PrototypeBuilder
{
    /**
	 * If this is `true` then the `abstract` keyword will not be outputted in the prototypes.
	 * @var boolean
	 */
    public $hideAbstract = false;

    protected function getDefaultValue(ReflectionParameter $p)
    {
        if ($p->isOptional()) {
            try {
                return ' = ' . var_export($p->getDefaultValue(), true);
            } catch (\ReflectionException $e) {
                return ' = NULL';
            }
        }

        return '';
    }

    protected function getTypeHint(ReflectionParameter $p)
    {
        if ($p->getClass()) {
            return '\\' . $p->getClass()->name . ' ';
        } elseif ($p->isCallable()) {
            return 'callable ';
        } elseif ($p->isArray()) {
            return 'array ';
        }

        return '';
    }

    protected function getName(ReflectionParameter $p)
    {
        $param = '$' . $p->getName();
        if ($p->isPassedbyReference()) {
            $param = '&' . $param;
        }

        return $param;
    }

    /**
	 * Get the prototype for the method.
	 * @param  ReflectionMethod $method
	 * @return string
	 */
    public function getPrototype(ReflectionMethod $method)
    {
        $modifiers = implode(' ', Reflection::getModifierNames($method->getModifiers()));
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

    /**
     * @param string $method
     * @return string
     */
    public function getPrototypeForNonExistentMethod($method)
    {
        ArgumentChecker::check($method, 'string');

        return "public function $method()";
    }
}
