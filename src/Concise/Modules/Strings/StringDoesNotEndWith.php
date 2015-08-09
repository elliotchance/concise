<?php

namespace Concise\Modules\Strings;

class StringDoesNotEndWith extends StringEndsWith
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
