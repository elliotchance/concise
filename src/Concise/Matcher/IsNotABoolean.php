<?php

namespace Concise\Matcher;

class IsNotABoolean extends IsABoolean
{
    public function supportedSyntaxes()
    {
        return array(
            '? is not a boolean' => 'Assert a value is not true or false.',
            '? is not a bool' => 'Assert a value is not true or false.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
