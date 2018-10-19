<?php

namespace Concise\Mock;

use Concise\Core\ArgumentChecker;
use Reflection;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionType;

class PrototypeBuilder
{
    /**
     * If this is `true` then the `abstract` keyword will not be outputted in
     * the prototypes.
     *
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
        } elseif (method_exists($p, 'isCallable') && $p->isCallable()) {
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

    protected function getReturnType(ReflectionMethod $method)
    {
        if ($method->hasReturnType()) {
            $returnType = $method->getReturnType();
            if ($returnType->isBuiltin()) {
                return ' : ' . $method->getReturnType();
            } else {
                return ' : \\' . $method->getReturnType();
            }
        }

        return '';
    }

    /**
     * Get the prototype for the method.
     *
     * @param  ReflectionMethod $method
     * @return string
     */
    public function getPrototype(ReflectionMethod $method)
    {
        $modifiers =
            implode(' ', Reflection::getModifierNames($method->getModifiers()));
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

        $returnType = $this->getReturnType($method);

        return $modifiers . ' function ' . $method->getName() . "(" .
        implode(', ', $parameters) . ")" . $returnType;
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
