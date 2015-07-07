<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderAnythingTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testWithParameterCanAcceptAnything(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')
            ->with(self::ANYTHING)
            ->andReturn('foo')
            ->get();
        $this->assert($mock->myMethod(null), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testWithParameterCanAcceptAnythingElse(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')
            ->with(self::ANYTHING)
            ->andReturn('foo')
            ->get();
        $this->assert($mock->myMethod(123), equals, 'foo');
    }
}
