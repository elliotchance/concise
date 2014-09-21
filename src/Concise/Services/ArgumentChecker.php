<?php

namespace Concise\Services;

use InvalidArgumentException;

class ArgumentChecker
{
    public static function check($value, $types, $argumentNumber)
    {
        $checker = new DataTypeChecker();

        try {
            return $checker->check(array($types), $value);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Argument $argumentNumber: " . $e->getMessage());
        }
    }
}
