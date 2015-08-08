<?php

namespace Concise\Modules\Strings;

class StringDoesNotStartWith extends StringStartsWith
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
