<?php

namespace Concise\Modules\Arrays;

class DoesNotHaveKeys extends HasKeys
{
    const DESCRIPTION = '';

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
