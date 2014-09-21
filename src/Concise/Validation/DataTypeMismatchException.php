<?php

namespace Concise\Validation;

use InvalidArgumentException;

class DataTypeMismatchException extends InvalidArgumentException
{
    protected $expectedTypes = array();

    public function getExpectedTypes()
    {
        return $this->expectedTypes;
    }

    public function setExpectedTypes(array $expectedTypes)
    {
        $this->expectedTypes = $expectedTypes;
    }
}
