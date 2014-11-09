<?php

namespace Concise\Services;

class TimeFormatter
{
    public function format($seconds)
    {
        return $seconds . ' second' . (($seconds == 1) ? '' : 's');
    }
}
