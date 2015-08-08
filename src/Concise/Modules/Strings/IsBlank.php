<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcher;

class IsBlank extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === '';
    }

    public function getTags()
    {
        return array();
    }
}
