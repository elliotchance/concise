<?php

namespace Concise\Validation;

use InvalidArgumentException;

class ArgumentChecker
{
    /**
     * @param string $types
     */
    public static function check($value, $types, $argumentNumber = 1)
    {
        $checker = new DataTypeChecker();

        try {
            return $checker->check(explode(',', $types), $value);
        } catch (DataTypeMismatchException $e) {
            throw new InvalidArgumentException($e->getMessage() . " for argument {$argumentNumber}");
        }
    }
}
