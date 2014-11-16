<?php

namespace Concise\Matcher;

use Concise\Services\TimestampToEpochConverter;

class DateIsAfter extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'date ?:int,string,DateTime is after ?:int,string,DateTime' => 'A date/time is after another date/time, returns original date in the same format as provided.',
        );
    }

    public function match($syntax, array $data = array())
    {
        $converter = new TimestampToEpochConverter();
        $d = $converter->convertAll($data);

        if (in_array(false, $d) || $d[0] < $d[1]) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array(Tag::DATE_AND_TIME);
    }
}
