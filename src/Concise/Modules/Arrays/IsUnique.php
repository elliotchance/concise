<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class IsUnique extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return count($data[0]) === count(array_unique($data[0]));
    }

    public function getTags()
    {
    }
}
