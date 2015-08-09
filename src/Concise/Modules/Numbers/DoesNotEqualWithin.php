<?php

namespace Concise\Modules\Numbers;

class DoesNotEqualWithin extends EqualsWithin
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
