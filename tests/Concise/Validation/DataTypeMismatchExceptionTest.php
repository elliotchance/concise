<?php

namespace Concise\Validation;

use Concise\TestCase;

class DataTypeMismatchExceptionTest extends TestCase
{
    public function testIsATypeOfInvalidArgumentException()
    {
        $this->aassert(new DataTypeMismatchException())->instanceOf('\InvalidArgumentException');
    }

    public function testExpectedTypesReturnsArray()
    {
        $e = new DataTypeMismatchException();
        $this->aassert($e->getExpectedTypes())->isAnArray;
    }

    public function testExpectedTypesCanBeSet()
    {
        $e = new DataTypeMismatchException('int', array('a'));
        $this->aassert($e->getExpectedTypes())->equals(array('a'));
    }

    public function testActualTypeReturnsUnknownIfUnknown()
    {
        $e = new DataTypeMismatchException();
        $this->aassert($e->getActualType())->equals('unknown');
    }

    public function testActualTypeCanBeSet()
    {
        $e = new DataTypeMismatchException('int');
        $this->aassert($e->getActualType())->equals('int');
    }

    public function testMessage()
    {
        $e = new DataTypeMismatchException('string', array('int', 'float'));
        $this->aassert($e->getMessage())
            ->equals('Expected int or float, but got string');
    }
}
