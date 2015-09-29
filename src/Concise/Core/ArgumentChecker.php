<?php

namespace Concise\Core;

use InvalidArgumentException;

class ArgumentChecker
{
    /**
     * @param mixed  $value
     * @param string $types comma-separated.
     * @param int    $argumentNumber
     * @return mixed
     */
    public static function check($value, $types, $argumentNumber = 1)
    {
        $checker = new DataTypeChecker();

        try {
            return $checker->check(explode(',', $types), $value);
        } catch (DataTypeMismatchException $e) {
            throw new InvalidArgumentException(
                $e->getMessage() . " for argument {$argumentNumber}"
            );
        }
    }
}
