<?php

namespace Concise\Matcher;

class HasKey extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:array has key ?:int,string' => 'Assert an array has key, returns value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if (!array_key_exists($data[1], $data[0])) {
            throw new DidNotMatchException();
        }

        return $data[0][$data[1]];
    }

    public function getTags()
    {
        return array(Tag::ARRAYS);
    }
}
