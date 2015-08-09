<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class IsAnAssociativeArray extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        $arr = $data[0];

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
