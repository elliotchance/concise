<?php

namespace Concise\Matcher;

use InvalidArgumentException;

class Syntax
{
    protected $syntax;

    protected $class;

    protected $method;

    public function __construct($syntax, $method)
    {
        if (strpos($method, '::') === false) {
            throw new InvalidArgumentException(
                "Method must be in the form of <class>::<method>"
            );
        }
        list($this->class, $this->method) = explode("::", $method);
        if (!class_exists($this->class)) {
            throw new InvalidArgumentException(
                "Class '$this->class' does not exist."
            );
        }
        $this->syntax = $syntax;
    }

    public function getSyntax()
    {
        return $this->syntax;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getRawSyntax()
    {
        return preg_replace('/\\?:[^\s$]+/i', '?', $this->syntax);
    }
}
