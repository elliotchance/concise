<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderAbstractTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testNiceMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myAbstractMethod() is abstract and has no
     *     associated action
     * @dataProvider abstractBuilders
     */
    public function testCallingAnAbstractMethodWithNoRuleThrowsException(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->get();
        $mock->myAbstractMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myAbstractMethod() is abstract and has no
     *     associated action
     * @dataProvider abstractBuilders
     */
    public function testCallingAnAbstractMethodOnANiceMockWithNoRuleThrowsException(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->get();
        $mock->myAbstractMethod();
    }

    /**
     * @dataProvider abstractBuilders
     */
    public function testAbstractMethodsCanHaveRulesAttached(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myAbstractMethod')->get();
        $this->assert($mock->myAbstractMethod(), is_null);
    }
}
