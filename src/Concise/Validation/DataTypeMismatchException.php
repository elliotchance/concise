<?php

namespace Concise\Validation;

use InvalidArgumentException;

class DataTypeMismatchException extends InvalidArgumentException
{
    public function getExpectedTypes()
    {
        return array();
    }
}
