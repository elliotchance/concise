<?php

namespace Concise\Console\ResultPrinter;

interface StatisticsInterface
{
    public function getSuccessCount();

    public function getFailureCount();

    public function getErrorCount();

    public function getIncompleteCount();

    public function getRiskyCount();

    public function getSkippedCount();

    public function getTestCount();

    public function getTotalTestCount();

    public function getAssertionCount();
}
