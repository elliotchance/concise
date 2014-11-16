<?php

namespace Concise\Matcher;

use Concise\Services\TimestampToEpochConverter;

class DateIsBefore extends AbstractDateComparison
{
    public function supportedSyntaxes()
    {
        return array(
            'date ?:int,string,DateTime is before ?:int,string,DateTime' => 'A date/time is before another date/time, returns original date in the same format as provided.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return parent::compare($data, 1);
    }
}
