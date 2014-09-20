<?php

namespace Concise\Mock;

class ArgumentMatcher
{
    public function match(array $a, array $b)
    {
        if (count($a) + count($b) === 0) {
            return true;
        }
        if (count($a) !== count($b)) {
            return false;
        }

        return $a[0] === $b[0];
    }
}
