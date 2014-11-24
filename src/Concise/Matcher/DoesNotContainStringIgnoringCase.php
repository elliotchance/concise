<?php

namespace Concise\Matcher;

class DoesNotContainStringIgnoringCase extends DoesNotContainString
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string does not contain string ?:string ignoring case' => 'A string does not contain a substring (ignoring case-sensitivity). Returns original string.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return parent::match(null, array(strtolower($data[0]), strtolower($data[1])));
    }

    public function getTags()
    {
        return array(Tag::STRINGS);
    }
}
