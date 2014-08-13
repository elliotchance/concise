<?php

namespace Concise\Matcher;

class IsNotUnique extends IsUnique
{
    public function supportedSyntaxes()
    {
        return array(
            '?:array is not unique' => 'Assert that an array only has at least one element that is repeated.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
