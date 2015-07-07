<?php

namespace Concise\Matcher;

use Concise\Services\TimestampToEpochConverter;

abstract class AbstractDateComparison extends AbstractNestedMatcher
{
    /**
     * http://stackoverflow.com/a/20460461/1470961
     * @param int $n
     * @return bool
     */
    protected function getSign($n)
    {
        return ($n > 0) - ($n < 0);
    }

    /**
     * @param array   $data
     * @param integer $sign
     * @throws DidNotMatchException
     * @return
     */
    public function compare(array $data, $sign)
    {
        $converter = new TimestampToEpochConverter();
        $d = $converter->convertAll($data);

        $s = $this->getSign($d[0] - $d[1]);
        if (in_array(false, $d) || $s == $sign || 0 == $s) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    public function getTags()
    {
        return array(Tag::DATE_AND_TIME);
    }
}
