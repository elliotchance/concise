<?php

namespace Concise\Modules\Booleans;

class IsFalsy extends IsTruthy
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
