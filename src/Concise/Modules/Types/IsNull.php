<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsNull extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return is_null($data[0]);
    }
}
