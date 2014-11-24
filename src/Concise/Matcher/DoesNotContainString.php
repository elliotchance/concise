<?php

namespace Concise\Matcher;

class DoesNotContainString extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string does not contain string ?:string' => 'A string does not contain a substring. Returns original string.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if (strpos($data[0], $data[1]) !== false) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array(Tag::STRINGS);
    }
}
