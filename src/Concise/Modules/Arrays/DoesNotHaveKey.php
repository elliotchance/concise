<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcher;

class DoesNotHaveKey extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return !array_key_exists($data[1], $data[0]);
    }

    public function getTags()
    {
        return array();
    }
}
