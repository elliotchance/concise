<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;

class HasKey extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        if (!array_key_exists($data[1], $data[0])) {
            throw new DidNotMatchException();
        }

        return $data[0][$data[1]];
    }

    public function getTags()
    {
        return array();
    }
}
