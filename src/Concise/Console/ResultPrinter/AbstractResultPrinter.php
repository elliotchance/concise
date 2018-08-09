<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\TestRunner\TestResultDelegateInterface;
use Exception;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;

abstract class AbstractResultPrinter
    implements TestResultDelegateInterface, StatisticsInterface
{
    /**
     * @var integer
     */
    public $failureCount = 0;

    /**
     * @var integer
     */
    public $errorCount = 0;

    /**
     * @var integer
     */
    public $incompleteCount = 0;

    /**
     * @var integer
     */
    public $skippedCount = 0;

    /**
     * @var integer
     */
    public $riskyCount = 0;

    /**
     * @var integer
     */
    public $testCount = 0;

    /**
     * @var integer
     */
    public $totalTestCount = 0;

    /**
     * @var integer
     */
    public $assertionCount = 0;

    /**
     * @var boolean
     */
    protected $verbose = false;

    /**
     * @return integer
     */
    public function getSuccessCount()
    {
        return $this->getTestCount() - $this->getFailureCount() -
            $this->getErrorCount() - $this->getSkippedCount() -
            $this->getIncompleteCount() - $this->getRiskyCount();
    }

    /**
     * @return integer
     */
    public function getFailureCount()
    {
        return $this->failureCount;
    }

    /**
     * @return integer
     */
    public function getErrorCount()
    {
        return $this->errorCount;
    }

    /**
     * @return integer
     */
    public function getIncompleteCount()
    {
        return $this->incompleteCount;
    }

    /**
     * @return integer
     */
    public function getRiskyCount()
    {
        return $this->riskyCount;
    }

    /**
     * @return integer
     */
    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    /**
     * @return integer
     */
    public function getTestCount()
    {
        return $this->testCount;
    }

    /**
     * @return integer
     */
    public function getTotalTestCount()
    {
        return $this->totalTestCount;
    }

    /**
     * @return integer
     */
    public function getAssertionCount()
    {
        return $this->assertionCount;
    }

    public function endTest($status, Test $test, $time, Exception $e = null)
    {
    }

    public function startTestSuite(TestSuite $suite)
    {
    }

    public function endTestSuite(TestSuite $suite)
    {
    }

    /**
     * @param string $string
     */
    public function write($string)
    {
        echo $string;
    }

    public function end()
    {
    }

    /**
     * @param boolean $verbose
     */
    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }

    /**
     * @return boolean
     */
    public function isVerbose()
    {
        return $this->verbose;
    }
}
