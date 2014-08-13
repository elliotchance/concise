<?php

namespace Concise\Services;

class NumberToTimesConverter
{
    public function convert($number)
    {
        $number = (int) $number;
        if ($number === 0) {
            return 'never';
        }
        if ($number === 1) {
            return 'once';
        }
        if ($number === 2) {
            return 'twice';
        }

        return "$number times";
    }

    public function convertToMethod($number)
    {
        if ($number < 3) {
            return $this->convert($number) . '()';
        }

        return "exactly($number)";
    }
}
