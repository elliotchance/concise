<?php

namespace Concise\Validation;

use Concise\TestCase;

class DataTypeMismatchExceptionTest extends TestCase
{
    public function testIsATypeOfInvalidArgumentException()
    {
        $this->assert(new DataTypeMismatchException(), instance_of, '\InvalidArgumentException');
    }

    public function testExpectedTypesReturnsArray()
    {
        $e = new DataTypeMismatchException();
        $this->assert($e->getExpectedTypes(), is_an_array);
    }

    public function testExpectedTypesCanBeSet()
    {
        $e = new DataTypeMismatchException('int', array('a'));
        $this->assert($e->getExpectedTypes(), equals, array('a'));
    }

    public function testActualTypeReturnsUnknownIfUnknown()
    {
        $e = new DataTypeMismatchException();
        $this->assert($e->getActualType(), equals, 'unknown');
    }

    public function testActualTypeCanBeSet()
    {
        $e = new DataTypeMismatchException('int');
        $this->assert($e->getActualType(), equals, 'int');
    }

    public function testMessage()
    {
        $e = new DataTypeMismatchException('string', array('int', 'float'));
        $this->assert($e->getMessage(), equals, 'Expected int or float, but got string');
    }
}
