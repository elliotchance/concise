<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderDoTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testACallbackCanBeSet(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andDo(function () {})
            ->get();
        $this->assert($mock->myMethod(), equals, null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testTheCallbackWillBeExecuted(MockBuilder $builder)
    {
        $a = 123;
        $mock = $builder->stub('myMethod')->andDo(function () use (&$a) {
                    $a = 456;
                })
            ->get();
        $mock->myMethod();
        $this->assert($a, equals, 456);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testTheCallbackWillNotBeExecutedIfNotCalled(MockBuilder $builder)
    {
        $a = 123;
        $builder->stub('myMethod')->andDo(function () use (&$a) {
                    $a = 456;
                })
            ->get();
        $this->assert($a, equals, 123);
    }
}
