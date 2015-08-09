<?php

namespace Concise\Modules\Arrays;

class IsNotAnAssociativeArray extends IsAnAssociativeArray
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
