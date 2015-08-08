<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class IsAnEmptyArray extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return count($data[0]) === 0;
    }

    public function getTags()
    {
        return array();
    }
}
