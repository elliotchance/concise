<?php

namespace Concise\Modules\Numbers;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;

class Between extends AbstractNestedMatcher
{
    public function match($syntax, array $data = array())
    {
        if ($data[0] < $data[1] || $data[0] > $data[2]) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }
}
