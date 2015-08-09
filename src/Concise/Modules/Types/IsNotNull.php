<?php

namespace Concise\Modules\Types;

class IsNotNull extends IsNull
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
