<?php

namespace Concise\Mock;

use Concise\Core\ArgumentChecker;

class NumberToTimesConverter
{
    /**
     * @param  integer $number
     * @return string
     */
    public function convert($number)
    {
        ArgumentChecker::check($number, 'integer');

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
