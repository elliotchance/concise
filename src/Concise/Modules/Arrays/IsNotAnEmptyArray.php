<?php

namespace Concise\Modules\Arrays;

class IsNotAnEmptyArray extends IsAnEmptyArray
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
