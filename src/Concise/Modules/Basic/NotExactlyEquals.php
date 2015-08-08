<?php

namespace Concise\Modules\Basic;

use Concise\Matcher\ExactlyEquals;

class NotExactlyEquals extends ExactlyEquals
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
