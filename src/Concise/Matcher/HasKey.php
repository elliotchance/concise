<?php

namespace Concise\Matcher;

class HasKey extends AbstractNestedMatcher
{
    const DESCRIPTION = 'Assert an array has key.';

    public function supportedSyntaxes()
    {
        return array(
            '?:array has key ?:int,string' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        if (!array_key_exists($data[1], $data[0])) {
            throw new DidNotMatchException();
        }
        return true;
    }

    public function getTags()
    {
        return array(Tag::ARRAYS);
    }
}
