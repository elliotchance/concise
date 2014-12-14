<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderExposeTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider niceMockBuilders
     */
    public function testExposeASingleMethod(MockBuilder $builder)
    {
        $mock = $builder->expose('mySecretMethod')
            ->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage does not exist.
     * @dataProvider niceMockBuilders
     */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist(MockBuilder $builder)
    {
        $builder->expose('baz')
            ->get();
    }

    /**
     * @dataProvider niceMockBuilders
     */
    public function testExposeTwoMethodsWithSeparateParameters(MockBuilder $builder)
    {
        $mock = $builder->expose('myMethod', 'mySecondMethod')
            ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @dataProvider niceMockBuilders
     */
    public function testExposeTwoMethodsByCallingExposeTwice(MockBuilder $builder)
    {
        $mock = $builder->expose('myMethod')->expose('mySecondMethod')
            ->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    /**
     * @dataProvider niceMockBuilders
     */
    public function testExposeTwoMethodsWithArraySyntax(MockBuilder $builder)
    {
        $mock = $builder->expose(array('myMethod', 'mySecondMethod'))
            ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage You cannot expose a method on a mock that is not nice.
     * @dataProvider mockBuilders
     */
    public function testExposeIsNotAllowedOnAMock(MockBuilder $builder)
    {
        $builder->expose('myMethod')->get();
    }
}
