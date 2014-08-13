<?php

namespace Concise\Matcher;

class False extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'false' => 'Always fail.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return false;
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}
