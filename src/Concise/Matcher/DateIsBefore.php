<?php

namespace Concise\Matcher;

class DateIsBefore extends AbstractMatcher
{
    const DESCRIPTION = 'A number must be between two values (inclusive).';

    public function supportedSyntaxes()
    {
        return array(
            'date ? is before ?' => 'A date/time is before another date/time',
        );
    }

    public function match($syntax, array $data = array())
    {
        $left = strtotime($data[0]);
        if (!$left) {
            return false;
        }

        return $left < strtotime($data[1]);
    }

    public function getTags()
    {
        return array(Tag::TIMESTAMPS);
    }
}
