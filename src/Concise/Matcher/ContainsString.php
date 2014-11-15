<?php

namespace Concise\Matcher;

class ContainsString extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string contains string ?:string' => 'A string contains a substring. Returns original string.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if (strpos($data[0], $data[1]) === false) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array(Tag::STRINGS);
    }
}
