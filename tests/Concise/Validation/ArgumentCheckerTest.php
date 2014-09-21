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
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testFailureThrowsInvalidArgumentException()
    {
        ArgumentChecker::check(123, 'string', 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testDefaultArgumentIsOne()
    {
        ArgumentChecker::check(123, 'string');
    }
}
