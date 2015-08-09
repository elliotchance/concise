<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsAnObject extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_object($data[0]);
    }
}
