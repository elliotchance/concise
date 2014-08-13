<?php

namespace Concise\Matcher;

class IsNotAnEmptyArray extends IsAnEmptyArray
{
    const DESCRIPTION = 'Assert an array is not empty (at least one element).';

    public function supportedSyntaxes()
    {
        return array(
            '?:array is not empty array' => self::DESCRIPTION,
            '?:array is not an empty array' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
