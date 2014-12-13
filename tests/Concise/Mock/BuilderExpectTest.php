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
        $mock = $builder->expect('myMethod')->once()->andReturn(null)->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanCreateAnExpectationOfTwice(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->twice()->andReturn(null)->get();
        $mock->myMethod();
        $mock->myMethod();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage You cannot assign an action to 'myMethod()' when it is never expected.
     * @dataProvider allBuilders
     */
    public function testAddingAnActionOntoAMethodThatIsNeverExpectedThrowsException(MockBuilder $builder)
    {
        $builder->expect('myMethod')->never()->andReturn(null)
            ->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen(MockBuilder $builder)
    {
        $builder->expect('myMethod')->never()
            ->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanCreateAnExpectationOfASpecificAmountOfTimes(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->exactly(3)->andReturn(null)
            ->get();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testExactlyZeroIsTheSameAsNever(MockBuilder $builder)
    {
        $builder->expect('myMethod')->exactly(0)
            ->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testDefaultExpectationIsOnce(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->andReturn(null)
            ->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanCreateAnExpectationWithArgumentValues(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->with('foo')->andReturn('bar')
            ->get();
        $this->assert($mock->myMethod('foo'), equals, 'bar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanUseExpectsInsteadOfExpect(MockBuilder $builder)
    {
        $mock = $builder->expects('myMethod')
            ->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testExpectWithMultipleArguments(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod', 'mySecondMethod')
            ->get();
        $mock->myMethod();
        $mock->mySecondMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testExpectsWithMultipleArguments(MockBuilder $builder)
    {
        $mock = $builder->expects('myMethod', 'mySecondMethod')
            ->get();
        $mock->myMethod();
        $mock->mySecondMethod();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMultipleExpectsThatAreNeverExpected(MockBuilder $builder)
    {
        $builder->expect('myWithMethod', 'myMethod')->never()
            ->get();
    }
}
