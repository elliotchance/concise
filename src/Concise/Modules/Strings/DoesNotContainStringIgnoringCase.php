<?php

namespace Concise\Modules\Strings;

class DoesNotContainStringIgnoringCase extends DoesNotContainString
{
    public function match($syntax, array $data = array())
    {
        return parent::match(
            null,
            array(strtolower($data[0]), strtolower($data[1]))
        );
    }
}
