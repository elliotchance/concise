<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class IsTrue extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === true;
    }

    public function getTags()
    {
        return array();
    }
}
