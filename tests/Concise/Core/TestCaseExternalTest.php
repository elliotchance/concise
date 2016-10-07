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
        $this->testCase = new IndependentTestCase();
    }

    public function checkSomething()
    {
        $this->testCase->assert(3 + 5)->equals(8);
    }

    public function checkSomethingElse()
    {
        $this->testCase->assert(3 + 5)->equals(7);
    }

    public function checkSomethingAgain()
    {
        $this->testCase->assert(3 + 5)->equals(8);
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
