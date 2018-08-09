<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\TestCase;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Runner\BaseTestRunner;
use PHPUnit\Runner\PhptTestCase;

class ResultPrinterProxyDelegateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->mock(Test::class)->get();
    }

    public function testStartTestSuiteWillCallResultPrinter()
    {
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('count' => 0, 'testAt' => null))
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->expect('count')
            ->andReturn(123)
            ->stub('testAt')
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
        $testCase = $this->mock(PhptTestCase::class)
            ->disableConstructor()
            ->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(1);
    }

    public function testEndTestWillIncrementAssertionsRealAmountWhenUsingTestCase()
    {
        $testCase = $this->mock(TestCase::class)->expect(
            'getNumAssertions'
        )->andReturn(123)->get();
        $proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $proxy->endTest($testCase, 0);
        $this->assert($proxy->getResultPrinter()->getAssertionCount())
            ->equals(123);
    }

    public function testEndTestWillIncrementAssertionsByOneMultipleTimesIfLegacyPhptIsUsed()
    {
        $testCase = $this->mock(PhptTestCase::class)
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
        $testCase = $this->mock(TestCase::class)->stub(
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub('count')->andReturn(123, 456)
            ->stub('testAt')
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('count' => 0, 'testAt' => null))
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('count' => 0, 'testAt' => null))
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('count' => 0, 'testAt' => null))
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
        $suite = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('count' => 0, 'testAt' => null))
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
        $testCase = $this->mock(TestCase::class)->stub(
            array('getNumAssertions' => 1)
        )->get();
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expect('endTest')->with(
            BaseTestRunner::STATUS_PASSED,
            $testCase,
            0.1
        )->get();
        $proxy = new ResultPrinterProxy($resultPrinter);
        $proxy->endTest($testCase, 0.1);
    }
}
