<?php

namespace Concise\Services;

use DateTime;

class TimestampToEpochConverter
{
    public function convertAll(array $data)
    {
        foreach ($data as &$d) {
            $d = $this->convert($d);
        }

        return $data;
    }

    public function convert($d)
    {
        if (is_string($d)) {
            return strtotime($d);
        } elseif ($d instanceof DateTime) {
            return $d->getTimestamp();
        }

        return $d;
    }
}
