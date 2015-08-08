<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcher;
use Concise\Matcher\DidNotMatchException;

class DoesNotContainString extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        if (strpos($data[0], $data[1]) !== false) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array();
    }
}
