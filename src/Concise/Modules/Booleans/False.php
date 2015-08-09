<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class False extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return false;
    }
}
