<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class IsTruthy extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return (bool)$data[0];
    }
}
