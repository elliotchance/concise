<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractMatcher;

class HasPropertyWithExactValue extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        if (method_exists($data[0], '__get') && $data[0]->{$data[1]}) {
            return ($data[0]->{$data[1]} == $data[2]);
        }
        return array_key_exists($data[1], (array)$data[0]) &&
        ($data[0]->{$data[1]} === $data[2]);
    }
}
