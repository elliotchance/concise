<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsAnInteger extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_int($data[0]);
    }
}
