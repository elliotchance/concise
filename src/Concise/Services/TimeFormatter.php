<?php

namespace Concise\Services;

class TimeFormatter
{
    /**
     * @param double $number
     * @param string $word
     */
    protected function pluralize($number, $word)
    {
        return "{$number} {$word}" . (($number == 1) ? '' : 's');
    }

    /**
     * @param integer $size
     * @param string $word
     */
    protected function part(array &$r, &$seconds, $size, $word)
    {
        if ($seconds >= $size) {
            $x = floor($seconds / $size);
            $r[] = $this->pluralize($x, $word);
            $seconds -= $x * $size;
        }
    }

    /**
     * @param integer $seconds
     */
    public function format($seconds)
    {
        if (0 == $seconds) {
            return '0 seconds';
        }

        $r = array();
        $this->part($r, $seconds, 3600, 'hour');
        $this->part($r, $seconds, 60, 'minute');
        $this->part($r, $seconds, 1, 'second');
        return implode(' ', $r);
    }
}
