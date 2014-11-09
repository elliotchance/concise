<?php

namespace Concise\Services;

class TimeFormatter
{
    protected function pluralize($number, $word)
    {
        return "{$number} {$word}" . (($number == 1) ? '' : 's');
    }

    protected function part(array &$r, &$seconds, $size, $word)
    {
        if ($seconds >= $size) {
            $x = floor($seconds / $size);
            $r[] = $this->pluralize($x, $word);
            $seconds -= $x * $size;
        }
    }

    public function format($seconds)
    {
        if (0 == $seconds) {
            return '0 seconds';
        }

        $r = [];
        $this->part($r, $seconds, 3600, 'hour');
        $this->part($r, $seconds, 60, 'minute');
        $this->part($r, $seconds, 1, 'second');
        return implode(' ', $r);
    }
}
