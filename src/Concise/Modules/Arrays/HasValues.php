<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class HasValues extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        $keys = array_values($data[0]);
        foreach ($data[1] as $key) {
            if (!in_array($key, $keys)) {
                return false;
            }
        }

        return true;
    }
}
