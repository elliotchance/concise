<?php

namespace Concise\Modules\Strings;

class DoesNotContainStringIgnoringCase extends DoesNotContainString
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return parent::match(
            null,
            array(strtolower($data[0]), strtolower($data[1]))
        );
    }

    public function getTags()
    {
        return array();
    }
}
