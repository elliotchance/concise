<?php

namespace Concise\Matcher;

use DateTime;

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
        if ($data[0] instanceof DateTime) {
            $data[0] = $data[0]->format('c');
        }
        if ($data[1] instanceof DateTime) {
            $data[1] = $data[1]->format('c');
        }
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
