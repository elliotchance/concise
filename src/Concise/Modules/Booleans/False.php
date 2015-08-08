<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class False extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return false;
    }

    public function getTags()
    {
        return array();
    }
}
