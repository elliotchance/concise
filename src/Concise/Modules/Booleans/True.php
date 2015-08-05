<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcher;

class True extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'true' => 'Always pass.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return true;
    }

    public function getTags()
    {
        return array();
    }
}
