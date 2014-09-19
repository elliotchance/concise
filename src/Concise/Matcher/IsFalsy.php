<?php

namespace Concise\Matcher;

class IsFalsy extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is falsy' => 'Assert a value is a false-like value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === false;
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}