<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderExpectTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testCanCreateAnExpectation(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->once()->andReturn(null)
            ->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanCreateAnExpectationOfTwice(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->twice()->andReturn(null)
            ->get();
        $mock->myMethod();
        $mock->myMethod();
    }
}
