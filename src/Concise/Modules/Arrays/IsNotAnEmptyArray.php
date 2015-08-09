<?php

namespace Concise\Modules\Arrays;

class IsNotAnEmptyArray extends IsAnEmptyArray
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
