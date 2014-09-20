<?php

namespace Concise\Mock;

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
            $r = $r && $a[$i] == $b[$i];
        }

        return $r;
    }
}
