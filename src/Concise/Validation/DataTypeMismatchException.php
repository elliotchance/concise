<?php

namespace Concise\Validation;

use InvalidArgumentException;

class DataTypeMismatchException extends InvalidArgumentException
{
    protected $expectedTypes = array();

    protected $actualType = '';

    public function getExpectedTypes()
    {
        return $this->expectedTypes;
    }

    public function setExpectedTypes(array $expectedTypes)
    {
        $this->expectedTypes = $expectedTypes;
    }

    public function getActualType()
    {
        return $this->actualType;
    }

    public function setActualType($actualType)
    {
        $this->actualType = $actualType;
    }
}
