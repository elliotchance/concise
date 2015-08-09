<?php

namespace Concise\Modules\Basic;

class NotEquals extends Equals
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
