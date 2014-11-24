<?php

namespace Concise\Matcher;

class NotBetween extends AbstractMatcher
{
    const DESCRIPTION = 'A number must not be between two values (inclusive).';

    public function supportedSyntaxes()
    {
        return array(
            '?:number is not between ?:number and ?:number' => self::DESCRIPTION,
            '?:number not between ?:number and ?:number' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] < $data[1] || $data[0] > $data[2];
    }

    public function getTags()
    {
        return array(Tag::NUMBERS);
    }
}
