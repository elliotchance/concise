<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;

class ResultPrinterProxyDelegateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
    }

    public function testStartTestSuiteWillCallResultPrinter()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                              ->stub(array('count' => 0))
                              ->done();

        $resultPrinter = $this->mock('Concise\Console\TestRunner\TestResultDelegateInterface')
                              ->expect('startTestSuite')->with($suite)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
    }

    public function testWillSetTotalTestCountWhenTheSuiteBegins()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                      ->expect('count')->andReturn(123)
                      ->done();
        $proxy = new ResultPrinterProxy();
        $proxy->startTestSuite($suite);
        $this->assert($proxy->getResultPrinter()->getTotalTestCount(), equals, 123);
    }

    public function testEndTestWillIncrementAssertionsByOneIfLegacyPhptIsUsed()
    {
        $testCase = $this->mock('PHPUnit_Extensions_PhptTestCase')->disableConstructor()
                         ->done();
        $proxy = new ResultPrinterProxy();
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount(), equals, 1);
    }

    public function testEndTestWillIncrementAssertionsRealAmountWhenUsingTestCase()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')
                         ->expect('getNumAssertions')->andReturn(123)
                         ->done();
        $proxy = new ResultPrinterProxy();
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount(), equals, 123);
    }

    public function testEndTestWillIncrementAssertionsByOneMultipleTimesIfLegacyPhptIsUsed()
    {
        $testCase = $this->mock('PHPUnit_Extensions_PhptTestCase')->disableConstructor()
                         ->done();
        $proxy = new ResultPrinterProxy();
        $proxy->endTest($testCase, 0);
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount(), equals, 2);
    }

    public function testEndTestWillIncrementAssertionsRealAmountWhenUsingMultipleTestCases()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')
                         ->stub(array('getNumAssertions' => 123))
                         ->done();
        $proxy = new ResultPrinterProxy();
        $proxy->endTest($testCase, 0);
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount(), equals, 246);
    }

    public function testWillNotUpdateTheTotalTestIfMultipleTestSuitesStart()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                      ->stub('count')->andReturn(123, 456)
                      ->done();
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->stub('startTestSuite')
                              ->stub('endTestSuite')
                              ->stub('end')
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
        $this->assert($proxy->getResultPrinter()->getTotalTestCount(), equals, 123);
    }

    public function testStartTestSuiteWillCallResultPrinterMultipleTimes()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                              ->stub(array('count' => 0))
                              ->done();

        $resultPrinter = $this->mock('Concise\Console\TestRunner\TestResultDelegateInterface')
                              ->expect('startTestSuite')->with($suite)->twice()
                              ->stub('endTestSuite')
                              ->stub('end')
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testFinishWillBeCalledWithEndTestSuite()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                      ->stub(array('count' => 0))
                      ->done();
        $resultPrinter = $this->mock('Concise\Console\TestRunner\TestResultDelegateInterface')
                              ->expect('end')
                              ->stub('startTestSuite')
                              ->stub('endTestSuite')
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testEndTestSuiteWillBeCalledInResultPrinter()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                      ->stub(array('count' => 0))
                      ->done();
        $resultPrinter = $this->mock('Concise\Console\TestRunner\TestResultDelegateInterface')
                              ->expect('endTestSuite')->with($suite)
                              ->stub('end')
                              ->stub('startTestSuite')
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testFinishWillBeOnlyBeCalledOnce()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')->disableConstructor()
                      ->stub(array('count' => 0))
                      ->done();
        $resultPrinter = $this->mock('Concise\Console\TestRunner\TestResultDelegateInterface')
                              ->expect('end')
                              ->stub('startTestSuite')
                              ->stub('endTestSuite')
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testProxyWillCallAddSuccess()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')
                         ->stub(array('getNumAssertions' => 1))
                         ->done();
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter')
                              ->expect('endTest')->with(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED, $testCase, 0.1)
                              ->done();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->endTest($testCase, 0.1);
    }
}
