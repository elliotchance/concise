<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcher;

class IsBlank extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return $data[0] === '';
    }
}
