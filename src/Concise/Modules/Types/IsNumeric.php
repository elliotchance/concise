<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsNumeric extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_numeric($data[0]);
    }

    public function getTags()
    {
        return array();
    }
}
