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
        $e = new DataTypeMismatchException();
        $e->setExpectedTypes(array('a'));
        $this->assert($e->getExpectedTypes(), equals, array('a'));
    }

    public function testActualTypeReturnsEmptyIfUnknown()
    {
        $e = new DataTypeMismatchException();
        $this->assert($e->getActualType(), is_blank);
    }

    public function testActualTypeCanBeSet()
    {
        $e = new DataTypeMismatchException();
        $e->setActualType('int');
        $this->assert($e->getActualType(), equals, 'int');
    }
}
