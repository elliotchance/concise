<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

class ArgumentMatcher
{
    public function match(array $a, array $b)
    {
        $aLen = count($a);
        if ($aLen + count($b) === 0) {
            return true;
        }
        if ($aLen !== count($b)) {
            return false;
        }

        $r = true;
        for ($i = 0; $i < $aLen; ++$i) {
            if ($a[$i] === TestCase::ANYTHING) {
                continue;
            }
            $r = $r && $a[$i] == $b[$i];
        }

        return $r;
    }
}
