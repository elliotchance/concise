<?php

namespace Concise\Validation;

use InvalidArgumentException;

class DataTypeMismatchException extends InvalidArgumentException
{
    protected $expectedTypes;

    protected $actualType;

    public function __construct(
        $actualType = 'unknown',
        array $expectedTypes = array()
    ) {
        $join = implode(' or ', $expectedTypes);
        parent::__construct("Expected $join, but got $actualType");

        $this->actualType = $actualType;
        $this->expectedTypes = $expectedTypes;
    }

    public function getExpectedTypes()
    {
        return $this->expectedTypes;
    }

    public function getActualType()
    {
        return $this->actualType;
    }
}
