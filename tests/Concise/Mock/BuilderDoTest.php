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

    /**
     * @group #182
     * @dataProvider allBuilders
     */
    public function testAndDoWillBeProvidedACountThatStartsAt1(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andDo(function (InvocationInterface $i) {
                    return $i->getInvokeCount();
                })
            ->get();
        $this->assert($mock->myMethod(), equals, 1);
    }

    /**
     * @group #182
     * @dataProvider allBuilders
     */
    public function testAndDoWillBeProvidedACountThatIncrementsWithInvocations(MockBuilder $builder)
    {
        $c = 0;
        $mock = $builder->stub('myMethod')->andDo(function (InvocationInterface $i) use (&$c) {
                    $c = $i->getInvokeCount();
                })
            ->get();
        $mock->myMethod();
        $mock->myMethod();
        $this->assert($c, equals, 2);
    }

    /**
     * @group #182
     * @dataProvider allBuilders
     */
    public function testAndDoWillBeProvidedWithOriginalArgs(MockBuilder $builder)
    {
        $a = array();
        $mock = $builder->stub('myMethod')->andDo(function (InvocationInterface $i) use (&$a) {
                    $a = $i->getArguments();
                })
            ->get();
        $mock->myMethod('hello');
        $this->assert($a, equals, array('hello'));
    }
}
