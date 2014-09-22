<?php

namespace Concise\Console\ResultPrinter;

interface StatisticsInterface
{
    /**
     * @return integer
     */
    public function getSuccessCount();

    /**
     * @return integer
     */
    public function getFailureCount();

    /**
     * @return integer
     */
    public function getErrorCount();

    /**
     * @return integer
     */
    public function getIncompleteCount();

    /**
     * @return integer
     */
    public function getRiskyCount();

    /**
     * @return integer
     */
    public function getSkippedCount();

    /**
     * @return integer
     */
    public function getTestCount();

    /**
     * @return integer
     */
    public function getTotalTestCount();

    /**
     * @return integer
     */
    public function getAssertionCount();
}
