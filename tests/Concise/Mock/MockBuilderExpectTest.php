<?php

namespace Concise\Mock;

use \Concise\TestCase;

/**
 * @group mocking
 */
class MockBuilderExpectTest extends TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testUsingExpectationCountBeforeWithWillThrowException()
    {
        $this->mock()
             ->expects('myMethod')->once()->with('foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage When using with you must specify expecations for each with():
     * @expectedExceptionMessage ->expects('myMethod')->with("foo")->twice()
     */
    public function testAnExceptionShouldCorrectExplainUsingWithAndExpectationTimes()
    {
        $this->mock()
             ->expects('myMethod')->twice()->with("foo");
    }
}
