<?php

namespace Concise\Modules\Booleans;

class IsFalsy extends IsTruthy
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
