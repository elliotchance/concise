<?php

namespace Concise\Matcher;

class IsABoolean extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is a boolean' => 'Assert a value is true or false.',
            '? is a bool' => 'Assert a value is true or false.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_bool($data[0]);
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}
