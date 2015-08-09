<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsAnArray extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_array($data[0]);
    }
}
