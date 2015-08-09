<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractMatcher;

class DoesNotHaveProperty extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return !array_key_exists($data[1], (array)$data[0]);
    }
}
