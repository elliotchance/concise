<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class IsAnEmptyArray extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return count($data[0]) === 0;
    }
}
