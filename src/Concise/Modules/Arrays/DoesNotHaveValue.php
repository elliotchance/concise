<?php

namespace Concise\Modules\Arrays;

class DoesNotHaveValue extends HasValue
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
