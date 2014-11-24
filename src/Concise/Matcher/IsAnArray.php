<?php

namespace Concise\Matcher;

class IsAnArray extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is an array' => 'Assert a value is an array.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_array($data[0]);
    }

    public function getTags()
    {
        return array(Tag::ARRAYS, Tag::TYPES);
    }
}
