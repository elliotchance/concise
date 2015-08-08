<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class IsTruthy extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return (bool)$data[0];
    }

    public function getTags()
    {
        return array();
    }
}
