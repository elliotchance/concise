<?php

namespace Concise\Modules\Arrays;

class IsNotUnique extends IsUnique
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
