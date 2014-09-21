<?php

namespace Concise\Validation;

use Concise\TestCase;

class ArgumentCheckerTest extends TestCase
{
    public function testSuccessReturnsOriginalValue()
    {
        $this->assert(ArgumentChecker::check(123, 'int', 1), exactly_equals, 123);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument 1: integer not found in string
     */
    public function testFailureThrowsInvalidArgumentException()
    {
        ArgumentChecker::check(123, 'string', 1);
    }
}
