<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class HasKeys extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        $keys = array_keys($data[0]);
        foreach ($data[1] as $key) {
            if (!in_array($key, $keys)) {
                return false;
            }
        }

        return true;
    }
}
