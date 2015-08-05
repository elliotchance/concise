<?php

namespace Concise\Matcher;

use InvalidArgumentException;

class Syntax
{
    public function __construct($syntax, $method)
    {
        list($class, ) = explode("::", $method);
        if (!class_exists($class)) {
            throw new InvalidArgumentException("Class '$class' does not exist.");
        }
    }

    public function getSyntax()
    {
        return '? equals ?';
    }

    public function getClass()
    {
        return 'stdClass';
    }

    public function getMethod()
    {
        return 'method';
    }
}
