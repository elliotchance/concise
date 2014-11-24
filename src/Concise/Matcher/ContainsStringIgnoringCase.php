<?php

namespace Concise\Matcher;

class ContainsStringIgnoringCase extends ContainsString
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string contains string ?:string ignoring case' => 'A string contains a substring (ignoring case-sensitivity). Returns original string.',
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
