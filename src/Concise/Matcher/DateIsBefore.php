<?php

namespace Concise\Matcher;

use DateTime;

class DateIsBefore extends IsLessThan
{
    public function supportedSyntaxes()
    {
        return array(
            'date ?:int,string,DateTime is before ?:int,string,DateTime' => 'A date/time is before another date/time',
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

        return parent::match(null, $data);
    }

    public function getTags()
    {
        return array(Tag::TIMESTAMPS);
    }
}
