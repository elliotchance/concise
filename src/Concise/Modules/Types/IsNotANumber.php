<?php

namespace Concise\Modules\Types;

class IsNotANumber extends IsANumber
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
