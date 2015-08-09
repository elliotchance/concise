<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class DoesNotHaveKey extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return !array_key_exists($data[1], $data[0]);
    }
}
