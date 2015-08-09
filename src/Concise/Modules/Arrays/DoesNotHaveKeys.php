<?php

namespace Concise\Modules\Arrays;

class DoesNotHaveKeys extends HasKeys
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
