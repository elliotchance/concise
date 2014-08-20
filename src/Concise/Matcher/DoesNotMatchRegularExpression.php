<?php

namespace Concise\Matcher;

class DoesNotMatchRegularExpression extends MatchesRegularExpression
{
    const DESCRIPTION = 'Assert a string does not match a regular expression.';

    public function supportedSyntaxes()
    {
        return array(
            '?:string does not match regular expression ?:regex' => self::DESCRIPTION,
            '?:string doesnt match regular expression ?:regex' => self::DESCRIPTION,
            '?:string does not match regex ?:regex' => self::DESCRIPTION,
            '?:string doesnt match regex ?:regex' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
