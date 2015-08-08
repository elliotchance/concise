<?php

namespace Concise\Modules\Types;

class IsNotAnArray extends IsAnArray
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
