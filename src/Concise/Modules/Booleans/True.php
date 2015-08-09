<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class True extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return true;
    }
}
