<?php

namespace Concise\Matcher;

class StringEndsWith extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string ends with ?:string' => 'Assert a string ends with another string.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return ((substr($data[0], strlen($data[0]) - strlen($data[1])) === $data[1]));
    }

    public function getTags()
    {
        return array(Tag::STRINGS);
    }
}
