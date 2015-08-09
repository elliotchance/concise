<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;

class ContainsString extends AbstractNestedMatcher
{
    public function match($syntax, array $data = array())
    {
        if (strpos($data[0], $data[1]) === false) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }
}
