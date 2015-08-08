<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class HasValue extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return in_array($data[1], $data[0]);
    }

    public function getTags()
    {
        return array();
    }
}
