<?php

namespace Concise\Modules\Basic;

class NotExactlyEquals extends ExactlyEquals
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
