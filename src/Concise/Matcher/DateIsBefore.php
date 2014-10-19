<?php

namespace Concise\Matcher;

use DateTime;
use Concise\Services\TimestampToEpochConverter;

class DateIsBefore extends IsLessThan
{
    public function supportedSyntaxes()
    {
        return array(
            'date ?:int,string,DateTime is before ?:int,string,DateTime' => 'A date/time is before another date/time.',
        );
    }

    public function match($syntax, array $data = array())
    {
        $converter = new TimestampToEpochConverter();
        $data = $converter->convertAll($data);

        if (in_array(false, $data)) {
            return false;
        }

        return parent::match(null, $data);
    }

    public function getTags()
    {
        return array(Tag::DATE_AND_TIME);
    }
}
