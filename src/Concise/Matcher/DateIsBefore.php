<?php

namespace Concise\Matcher;

use DateTime;

class DateIsBefore extends AbstractMatcher
{
    const DESCRIPTION = 'A number must be between two values (inclusive).';

    public function supportedSyntaxes()
    {
        return array(
            'date ?:string,object is before ?:string,object' => 'A date/time is before another date/time',
        );
    }

    public function match($syntax, array $data = array())
    {
        foreach ($data as &$d) {
            if ($d instanceof DateTime) {
                $d = $d->format('c');
            }
            $d = strtotime($d);
            if (!$d) {
                return false;
            }
        }

        return $data[0] < $data[1];
    }

    public function getTags()
    {
        return array(Tag::TIMESTAMPS);
    }
}
