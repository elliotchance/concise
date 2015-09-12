<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;

class ResultPrinterProxyDelegateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->mock('PHPUnit_Framework_Test')->get();
    }

    public function testStartTestSuiteWillCallResultPrinter()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('count' => 0))
            ->get();

        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('startTestSuite')
                ->with($suite)
                ->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
    }

    public function testWillSetTotalTestCountWhenTheSuiteBegins()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->expect('count')
            ->andReturn(123)
            ->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->startTestSuite($suite);
        $this->assert($proxy->getResultPrinter()->getTotalTestCount())
            ->equals(123);
    }

    protected function getMuteResultPrinter()
    {
        return $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->get();
    }

    public function testEndTestWillIncrementAssertionsByOneIfLegacyPhptIsUsed()
    {
        $testCase = $this->mock('PHPUnit_Extensions_PhptTestCase')
            ->disableConstructor()
            ->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(1);
    }

    public function testEndTestWillIncrementAssertionsRealAmountWhenUsingTestCase()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')->expect(
            'getNumAssertions'
        )->andReturn(123)->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(123);
    }

    public function testEndTestWillIncrementAssertionsByOneMultipleTimesIfLegacyPhptIsUsed()
    {
        $testCase = $this->mock('PHPUnit_Extensions_PhptTestCase')
            ->disableConstructor()
            ->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(2);
    }

    public function testEndTestWillIncrementAssertionsRealAmountWhenUsingMultipleTestCases()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')->stub(
            array('getNumAssertions' => 123)
        )->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(246);
    }

    public function testWillNotUpdateTheTotalTestIfMultipleTestSuitesStart()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub('count')
            ->andReturn(123, 456)
            ->get();
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('startTestSuite')->stub('endTestSuite')->stub('end')->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
        $this->assert($proxy->getResultPrinter()->getTotalTestCount())
            ->equals(123);
    }

    public function testStartTestSuiteWillCallResultPrinterMultipleTimes()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('count' => 0))
            ->get();

        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('startTestSuite')
                ->with($suite)
                ->twice()
                ->stub('endTestSuite')
                ->stub('end')
                ->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testFinishWillBeCalledWithEndTestSuite()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('count' => 0))
            ->get();
        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('end')
                ->stub('startTestSuite')
                ->stub('endTestSuite')
                ->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testEndTestSuiteWillBeCalledInResultPrinter()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('count' => 0))
            ->get();
        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('endTestSuite')
                ->with($suite)
                ->stub('end')
                ->stub('startTestSuite')
                ->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testFinishWillBeOnlyBeCalledOnce()
    {
        $suite = $this->mock('PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('count' => 0))
            ->get();
        $resultPrinter =
            $this->mock('Concise\Console\ResultPrinter\AbstractResultPrinter')
                ->expect('end')
                ->stub('startTestSuite')
                ->stub('endTestSuite')
                ->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->startTestSuite($suite);
        $proxy->startTestSuite($suite);
        $proxy->endTestSuite($suite);
        $proxy->endTestSuite($suite);
    }

    public function testProxyWillCallAddSuccess()
    {
        $testCase = $this->mock('PHPUnit_Framework_TestCase')->stub(
            array('getNumAssertions' => 1)
        )->get();
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expect('endTest')->with(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED,
            $testCase,
            0.1
        )->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->endTest($testCase, 0.1);
    }
}
