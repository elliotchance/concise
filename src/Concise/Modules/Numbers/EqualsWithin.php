<?php

namespace Concise\Modules\Numbers;

use Concise\Matcher\AbstractMatcher;

class EqualsWithin extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return abs($data[1] - $data[0]) <= $data[2];
    }
}
