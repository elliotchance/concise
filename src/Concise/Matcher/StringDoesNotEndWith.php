<?php

namespace Concise\Matcher;

class StringDoesNotEndWith extends StringEndsWith
{
    public function supportedSyntaxes()
    {
        return array(
            '? does not end with ?' => 'Assert a string does not end with another string.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
