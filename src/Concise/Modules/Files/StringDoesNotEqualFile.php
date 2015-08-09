<?php

namespace Concise\Modules\Files;

class StringDoesNotEqualFile extends StringEqualsFile
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
