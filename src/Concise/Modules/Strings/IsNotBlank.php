<?php

namespace Concise\Modules\Strings;

class IsNotBlank extends IsBlank
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
