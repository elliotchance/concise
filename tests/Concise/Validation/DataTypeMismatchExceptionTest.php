<?php

namespace Concise\Validation;

use Concise\TestCase;

class DataTypeMismatchExceptionTest extends TestCase
{
    public function testIsATypeOfInvalidArgumentException()
    {
        $this->assert(new DataTypeMismatchException(), instance_of, '\InvalidArgumentException');
    }
}
