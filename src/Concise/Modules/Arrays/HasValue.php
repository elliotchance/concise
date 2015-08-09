<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class HasValue extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return in_array($data[1], $data[0]);
    }
}
