<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcher;

class IsNull extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_null($data[0]);
    }

    public function getTags()
    {
        return array();
    }
}
