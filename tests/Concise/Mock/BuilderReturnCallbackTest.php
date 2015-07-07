<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderReturnCallbackTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackCanBeSet(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturnCallback(
            function () {
            }
        )->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackWillBeEvaluatedForItsReturnValue(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturnCallback(
            function () {
                return 'foo';
            }
        )->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackMustNotBeExecutedIfTheMethodWasNeverInvoked(
        MockBuilder $builder
    ) {
        $count = 0;
        $builder->stub('myMethod')->andReturnCallback(
            function () use (&$count) {
                ++$count;
            }
        )->get();
        $this->assert($count, equals, 0);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackWillBeProvidedACountThatStartsAt1(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturnCallback(
            function (InvocationInterface $i) {
                return $i->getInvokeCount();
            }
        )->get();
        $this->assert($mock->myMethod(), equals, 1);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackWillBeProvidedACountThatIncrementsWithInvocations(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturnCallback(
            function (InvocationInterface $i) {
                return $i->getInvokeCount();
            }
        )->get();
        $mock->myMethod();
        $this->assert($mock->myMethod(), equals, 2);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAReturnCallbackWillBeProvidedWithOriginalArgs(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturnCallback(
            function (InvocationInterface $i) {
                return $i->getArguments();
            }
        )->get();
        $this->assert($mock->myMethod('hello'), equals, array('hello'));
    }
}
