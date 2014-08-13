<?php

namespace Concise\Matcher;

class IsNotAnAssociativeArray extends IsAnAssociativeArray
{
    public function supportedSyntaxes()
    {
        return array(
            '?:array is not an associative array' => 'Assert an array is associative.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
