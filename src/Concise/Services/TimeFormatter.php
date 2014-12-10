<?php

namespace Concise\Services;

class TimeFormatter
{
    /**
     * @param double $number
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
     * @param bool $small Use shorter output, '3 mins 20 secs' instead of '3 minutes 20 seconds'
     * @return string
     */
    public function format($seconds, $small = false)
    {
        if (0 == $seconds) {
            return $small ? '0 secs' : '0 seconds';
        }

        $r = array();
        $this->part($r, $seconds, 3600, 'hour');
        $this->part($r, $seconds, 60, 'minute');
        $this->part($r, $seconds, 1, $small ? 'sec' : 'second');
        return implode(' ', $r);
    }
}
