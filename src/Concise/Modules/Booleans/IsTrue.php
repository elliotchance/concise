<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class IsTrue extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return $data[0] === true;
    }
}
