<?php

namespace Concise\Core;

/**
 * When using concise with non-PHPUnit it has to still remain compatible
 */
class MyTinyTestSuite
{
    protected $testCase;

    public function __construct()
    {
        $this->testCase = new TestCase();
    }

    public function checkSomething()
    {
        $this->testCase->setUp();
        $this->testCase->assert(3 + 5)->equals(8);
        $this->testCase->tearDown();
    }

    public function checkSomethingElse()
    {
        $this->testCase->setUp();
        $this->testCase->assert(3 + 5)->equals(7);
        $this->testCase->tearDown();
    }

    public function checkSomethingAgain()
    {
        $this->testCase->setUp();
        $this->testCase->assert(3 + 5)->equals(8);
        $this->testCase->tearDown();
    }
}

class TestCaseExternalTest extends TestCase
{
    public function testAnExternalRunner()
    {
        $suite = new MyTinyTestSuite();
        $suite->checkSomething();
    }

    public function testAnExternalRunnerWillThrowAnExceptionOnFailure()
    {
        $this->assertClosure(
            function () {
                $suite = new MyTinyTestSuite();
                $suite->checkSomethingElse();
            }
        )->throws('Concise\Core\DidNotMatchException');
    }

    public function testAnExternalRunnerCanUseAssertThat()
    {
        $suite = new MyTinyTestSuite();
        $suite->checkSomethingAgain();
    }
}
