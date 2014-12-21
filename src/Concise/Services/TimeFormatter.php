<?php

namespace Concise\Services;

class TimeFormatter
{
    /**
     * @param double $number
     * @param string $word
     * @return string
     */
    protected function pluralize($number, $word)
    {
        return "{$number} {$word}" . (($number == 1) ? '' : 's');
    }

    /**
     * @param array $r
     * @param int $seconds
     * @param integer $size
     * @param string $word
     * @param bool $pluralize
     */
    protected function part(array &$r, &$seconds, $size, $word, $pluralize)
    {
        if ($seconds >= $size) {
            $x = floor($seconds / $size);
            $r[] = $pluralize ? $this->pluralize($x, $word) : "$x $word";
            $seconds -= $x * $size;
        }
    }

    /**
     * @param integer $seconds
     * @param bool $small Use shorter output, '3 min 20 sec' instead of '3 minutes 20 seconds'
     * @return string
     */
    public function format($seconds, $small = false)
    {
        if (0 == $seconds) {
            return $small ? '0 sec' : '0 seconds';
        }

        $r = array();
        $this->part($r, $seconds, 3600, $small ? 'hr' : 'hour', !$small);
        $this->part($r, $seconds, 60, $small ? 'min' : 'minute', !$small);
        $this->part($r, $seconds, 1, $small ? 'sec' : 'second', !$small);
        return implode(' ', $r);
    }
}
