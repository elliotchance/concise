<?php

namespace Concise\Services;

class TimeFormatter
{
    protected function pluralize($number, $word)
    {
        return "{$number} {$word}" . (($number == 1) ? '' : 's');
    }

    public function format($seconds)
    {
        if (0 == $seconds) {
            return '0 seconds';
        }

        $r = [];
        if ($seconds >= 60) {
            $minutes = floor($seconds / 60);
            $r[] = $this->pluralize($minutes, 'minute');
            $seconds -= $minutes * 60;
        }
        if ($seconds != 0) {
            $r[] = $this->pluralize($seconds, 'second');
        }
        return implode(' ', $r);
    }
}
