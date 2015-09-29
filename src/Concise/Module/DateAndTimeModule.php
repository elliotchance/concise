<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;
use DateTime;

class DateAndTimeModule extends AbstractModule
{
    public function getName()
    {
        return "Date and Time";
    }

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
     * @return mixed
     */
    protected function compare(array $data, $sign)
    {
        $d = $this->convertAll($data);

        $s = $this->getSign($d[0] - $d[1]);
        if (in_array(false, $d) || $s == $sign || 0 == $s) {
            throw new DidNotMatchException();
        }

        return $data[0];
    }

    /**
     * A date/time is after another date/time, returns original date in the same
     * format as provided.
     *
     * @syntax date ?:int,string,DateTime is after ?:int,string,DateTime
     * @return mixed
     * @throws DidNotMatchException
     */
    public function dateIsAfter()
    {
        return $this->compare($this->data, -1);
    }

    /**
     * A date/time is before another date/time, returns original date in the
     * same format as provided.
     *
     * @syntax date ?:int,string,DateTime is before ?:int,string,DateTime
     * @return mixed
     * @throws DidNotMatchException
     */
    public function dateIsBefore()
    {
        return $this->compare($this->data, 1);
    }

    protected function convertAll(array $data)
    {
        foreach ($data as &$d) {
            $d = $this->convert($d);
        }

        return $data;
    }

    protected function convert($d)
    {
        if (is_string($d)) {
            return strtotime($d);
        } elseif ($d instanceof DateTime) {
            return $d->getTimestamp();
        }

        return $d;
    }
}
