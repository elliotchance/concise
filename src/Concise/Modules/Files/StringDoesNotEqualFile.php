<?php

namespace Concise\Modules\Files;

class StringDoesNotEqualFile extends StringEqualsFile
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
