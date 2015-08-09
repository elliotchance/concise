<?php

namespace Concise\Modules\Numbers;

use Concise\Matcher\AbstractMatcher;

class IsLessThan extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return $data[0] < $data[1];
    }
}
