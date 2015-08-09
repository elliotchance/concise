<?php

namespace Concise\Modules\Urls;

use Concise\Matcher\AbstractMatcher;

class UrlIsValid extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return filter_var($data[0], FILTER_VALIDATE_URL) !== false;
    }
}
