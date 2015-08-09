<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class IsUnique extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return count($data[0]) === count(array_unique($data[0]));
    }
}
