<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsABoolean extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_bool($data[0]);
    }
}
