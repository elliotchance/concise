<?php

namespace Concise\Modules\Types;

class IsNotAnArray extends IsAnArray
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
