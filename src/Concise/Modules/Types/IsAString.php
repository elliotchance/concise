<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsAString extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_string($data[0]);
    }
}
