<?php

namespace Concise\Services;

class TimeFormatter
{
    public function format($seconds)
    {
        if (60 == $seconds) {
            return '1 minute';
        }
        return $seconds . ' second' . (($seconds == 1) ? '' : 's');
    }
}
