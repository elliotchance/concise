<?php

namespace Concise\Modules\Types;

class IsNotNumeric extends IsNumeric
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
