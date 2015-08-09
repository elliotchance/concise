<?php

namespace Concise\Modules\Types;

class IsNotAnInteger extends IsAnInteger
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
