<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderExpectTest extends TestCase
{
    public function testWeDoNotNeedToSpecifyAnActionForAnExpectationWeNeverWantToHappen()
    {
        $this->mock('\Concise\Mock\Mock1')
             ->expect('myMethod')->never()
             ->done();
    }

    public function testCanCreateAnExpectationOfASpecificAmountOfTimes()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expect('myMethod')->exactly(3)->andReturn(null)
                     ->done();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }

    public function testExactlyZeroIsTheSameAsNever()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expect('myMethod')->exactly(0)
                     ->done();
    }

    public function testDefaultExpectationIsOnce()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expect('myMethod')->andReturn(null)
                     ->done();
        $mock->myMethod();
    }

    public function testCanCreateAnExpectationWithArgumentValues()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expect('myMethod')->with('foo')->andReturn('bar')
                     ->done();
        $this->assert($mock->myMethod('foo'), equals, 'bar');
    }

    public function testCanUseExpectsInsteadOfExpect()
    {
        $mock = $this->mock('\Concise\Mock\Mock1')
                     ->expects('myMethod')
                     ->done();
        $mock->myMethod();
    }

    /**
	 * @expectedException \Exception
	 */
    public function testUsingExpectationCountBeforeWithWillThrowException()
    {
        $mock = $this->mock()
                     ->expects('myMethod')->once()->with('foo');
    }

    /**
	 * @expectedException \Exception
	 * @expectedExceptionMessage When using with you must specify expecations for each with():
	 * @expectedExceptionMessage ->expects('myMethod')->with("foo")->twice()
	 */
    public function testAnExceptionShouldCorrectExplainUsingWithAndExpectationTimes()
    {
        $mock = $this->mock()
                     ->expects('myMethod')->twice()->with("foo");
    }
}
