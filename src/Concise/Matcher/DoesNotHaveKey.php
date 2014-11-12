<?php

namespace Concise\Matcher;

class DoesNotHaveKey extends HasKey
{
    const DESCRIPTION = 'Assert an array does not have a key.';

    public function supportedSyntaxes()
    {
        return array(
            '?:array does not have key ?:int,string' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        if (array_key_exists($data[1], $data[0])) {
            throw new DidNotMatchException();
        }
        return true;
    }
}
