<?php

namespace Concise\Matcher;

class IsTruthy extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is truthy' => 'Assert a value is a non false-like value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return (bool) $data[0];
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}
