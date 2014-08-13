<?php

namespace Concise\Matcher;

class IsNotANumber extends IsANumber
{
    public function supportedSyntaxes()
    {
        return array(
            '? is not a number' => 'Assert that a value is not an integer or floating-point.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
