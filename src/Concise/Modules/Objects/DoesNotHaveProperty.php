<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractMatcher;

class DoesNotHaveProperty extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return !array_key_exists($data[1], (array)$data[0]);
    }

    public function getTags()
    {
        return array();
    }
}
