<?php

namespace Concise\Modules\Types;

class IsNotABoolean extends IsABoolean
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
