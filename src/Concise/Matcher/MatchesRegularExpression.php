<?php

namespace Concise\Matcher;

class MatchesRegularExpression extends AbstractMatcher
{
    const DESCRIPTION = 'Assert a string matches a regular expression';

    public function supportedSyntaxes()
    {
        return array(
            '?:string matches regular expression ?:regex' => self::DESCRIPTION,
            '?:string matches regex ?:regex' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return preg_match($data[1], $data[0]) === 1;
    }

    public function getTags()
    {
        return array(Tag::STRINGS);
    }
}
