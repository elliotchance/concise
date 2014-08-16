<?php

namespace Concise\Matcher;

class StringDoesNotEqualFile extends StringEqualsFile
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string does not equal file ?:string' => "Compare string value with the contents of a file.",
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
