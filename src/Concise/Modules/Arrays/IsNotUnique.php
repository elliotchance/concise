<?php

namespace Concise\Modules\Arrays;

class IsNotUnique extends IsUnique
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
