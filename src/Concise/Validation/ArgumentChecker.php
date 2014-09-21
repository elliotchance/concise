<?php

namespace Concise\Validation;

use InvalidArgumentException;

class ArgumentChecker
{
    public static function check($value, $types, $argumentNumber = 1)
    {
        $checker = new DataTypeChecker();

        try {
            return $checker->check(array($types), $value);
        } catch (DataTypeMismatchException $e) {
            throw new InvalidArgumentException($e->getMessage() . " for argument {$argumentNumber}");
        }
    }
}
