<?php

namespace Concise\Services;

class MatcherSyntaxAndDescription
{
    /**
	 * @param  array $syntaxes
	 * @return array
	 */
    public function process(array $syntaxes)
    {
        $r = array();
        foreach ($syntaxes as $k => $v) {
            if (is_int($k)) {
                $r[$v] = null;
            } else {
                $r[$k] = $v;
            }
        }

        return $r;
    }
}
