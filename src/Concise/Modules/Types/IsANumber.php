<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsANumber extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_int($data[0]) || is_float($data[0]);
    }
}
