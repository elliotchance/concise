<?php

namespace Concise\Matcher;

class Between extends AbstractNestedMatcher
{
    const DESCRIPTION = 'A number must be between two values (inclusive), returns value.';

    public function supportedSyntaxes()
    {
        return array(
            '?:number is between ?:number and ?:number' => self::DESCRIPTION,
            '?:number between ?:number and ?:number' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        if ($data[0] < $data[1] || $data[0] > $data[2]) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array(Tag::NUMBERS);
    }
}
