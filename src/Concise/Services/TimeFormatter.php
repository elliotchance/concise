<?php

namespace Concise\Services;

class TimeFormatter
{
    public function format($seconds)
    {
        if ($seconds >= 60) {
            $minutes = ($seconds / 60);
            return $minutes . ' minute' . (($minutes == 1) ? '' : 's');
        }
        return $seconds . ' second' . (($seconds == 1) ? '' : 's');
    }
}
