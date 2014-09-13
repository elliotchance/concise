<?php

namespace Concise\Matcher;

class IsABoolean extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is a boolean' => 'Assert a value is true or false.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === true;
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}
