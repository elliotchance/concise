<?php

namespace Concise\Modules\Strings;

class StringDoesNotStartWith extends StringStartsWith
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
