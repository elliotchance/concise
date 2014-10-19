<?php

namespace Concise\Matcher;

use DateTime;

class DateIsBefore extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'date ?:int,string,DateTime is before ?:string,DateTime' => 'A date/time is before another date/time',
        );
    }

    public function match($syntax, array $data = array())
    {
        foreach ($data as &$d) {
            if (is_string($d)) {
                $d = strtotime($d);
            } elseif ($d instanceof DateTime) {
                $d = $d->getTimestamp();
            }
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
