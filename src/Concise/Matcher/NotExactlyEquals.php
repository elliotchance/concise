<?php

namespace Concise\Matcher;

class NotExactlyEquals extends ExactlyEquals
{
    const DESCRIPTION = 'Assert two values are of exactly the same type and value.';

    public function supportedSyntaxes()
    {
        return array(
            '? is not exactly equal to ?' => self::DESCRIPTION,
            '? does not exactly equal ?' => self::DESCRIPTION,
            '? is not the same as ?' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
