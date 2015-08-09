<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcher;

class StringStartsWith extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return ((substr($data[0], 0, strlen($data[1])) === $data[1]));
    }
}
