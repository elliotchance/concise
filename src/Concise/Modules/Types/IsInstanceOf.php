<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsInstanceOf extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        $interfaces = class_implements($data[0]);

        if (is_string($data[0])) {
            return true;
        }
        return (get_class($data[0]) === $data[1]) ||
        is_subclass_of($data[0], $data[1]) ||
        array_key_exists($data[1], $interfaces);
    }
}
