<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\TestCase;

class ResultPrinterProxyStatisticsTest extends TestCase
{
    /**
     * @var ResultPrinterProxy
     */
    protected $proxy;

    protected $test;

    protected $e;

    public function setUp()
    {
        parent::setUp();
        $this->proxy = new ResultPrinterProxy($this->getMuteResultPrinter());
        $this->test =
            $this->mock('PHPUnit_Framework_TestCase')->stub('getName')->get();
        $this->e = $this->mock('Exception')->get();
    }

    protected function getMuteResultPrinter()
    {
        return $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->get();
    }

    public function testAddFailureWillIncrementCount()
    {
        $this->e = $this->mock('PHPUnit_Framework_AssertionFailedError')->get();
        $this->proxy->addFailure($this->test, $this->e, 0);
        $this->assert($this->proxy->getResultPrinter()->getFailureCount())
            ->equals(1);
    }

    public function testAddErrorWillIncrementCount()
    {
        $this->proxy->addError($this->test, $this->e, 0);
        $this->assert($this->proxy->getResultPrinter()->getErrorCount())
            ->equals(1);
    }

    public function testAddIncompleteWillIncrementCount()
    {
        $this->proxy->addIncompleteTest($this->test, $this->e, 0);
        $this->assert($this->proxy->getResultPrinter()->getIncompleteCount())
            ->equals(1);
    }

    public function testAddSkippedWillIncrementCount()
    {
        $this->proxy->addSkippedTest($this->test, $this->e, 0);
        $this->assert($this->proxy->getResultPrinter()->getSkippedCount())
            ->equals(1);
    }

    public function testAddRiskyWillIncrementCount()
    {
        $this->proxy->addRiskyTest($this->test, $this->e, 0);
        $this->assert($this->proxy->getResultPrinter()->getRiskyCount())
            ->equals(1);
    }
}
