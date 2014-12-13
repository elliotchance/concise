<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderStubTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testCanStubMethodWithAssociativeArray(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myMethod' => 123))
            ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStubbingWithAnArrayCanCreateMultipleStubs(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myMethod' => 123, 'mySecondMethod' => 'bar'))
            ->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage stub() called with array must have at least 1 element.
     * @dataProvider allBuilders
     */
    public function testStubbingWithAnArrayMustHaveMoreThanZeroElements(MockBuilder $builder)
    {
        $builder->stub(array())
            ->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCallingMethodOnNiceMockWithStub(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myMethod' => 123))
            ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStubsCanBeCreatedByChainingAnAction(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturn(123)
            ->get();
        $this->assert($mock->myMethod(), equals, 123);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStubWithNoActionWillReturnNull(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')
            ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStubCanReturnNull(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturn(null)
            ->get();
        $this->assert($mock->myMethod(), is_null);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage whatever
     * @dataProvider allBuilders
     */
    public function testStubCanThrowException(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andThrow(new \Exception('whatever'))
            ->get();
        $mock->myMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage myMethod() has more than one action attached.
     * @dataProvider allBuilders
     */
    public function testMethodsCanOnlyHaveOneActionAppliedToThem(MockBuilder $builder)
    {
        $builder->stub('myMethod')->andReturn(123)->andReturn(456)
            ->get();
    }

    protected function getLastElement(array $a)
    {
        return $a[count($a) - 1];
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockSetsActualCallsToZeroWhenRuleIsCreated(MockBuilder $builder)
    {
        $builder->stub(array('myMethod' => 123))
            ->get();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 0);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockSetsCalledTimesToOneWhenMethodIsCalled(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myMethod' => 123))
            ->get();

        $mock->myMethod();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 1);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockSetsCalledTimesIncrementsWithMultipleCalls(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myMethod' => 123))
            ->get();

        $mock->myMethod();
        $mock->myMethod();

        $mock = $this->getLastElement($this->getMockManager()->getMocks());
        $this->assert(count($mock['instance']->getCallsForMethod('myMethod')), exactly_equals, 2);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStubbingMultipleMethodsWithMultipleArguments(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod', 'mySecondMethod')
            ->get();
        $this->assert($mock->mySecondMethod(), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testFirstMethodOfMultipleStubsReceivesAction(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod', 'mySecondMethod')->andReturn('foo')
            ->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testSecondMethodOfMultipleStubsReceivesAction(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod', 'mySecondMethod')->andReturn('foo')
            ->get();
        $this->assert($mock->mySecondMethod(), equals, 'foo');
    }
}
