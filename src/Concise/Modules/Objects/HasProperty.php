<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;

class HasProperty extends AbstractNestedMatcher
{
    public function match($syntax, array $data = array())
    {
        if (!array_key_exists($data[1], (array)$data[0])) {
            throw new DidNotMatchException();
        }

        return $data[0]->{$data[1]};
    }
}
