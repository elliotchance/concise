<?php

namespace Concise\Console\TestRunner;

use Exception;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;

interface TestResultDelegateInterface
{
    /**
     * @param int       $status A status constant from BaseTestRunner
     * @param Test      $test The test that just finished.
     * @param float     $time The number of seconds the test took
     *     to execute.
     * @param Exception $e The error (applies to all statuses
     *     except STATUS_PASSED)
     * @return void
     */
    public function endTest($status, Test $test, $time, Exception $e = null);

    /**
     * @param TestSuite $suite
     * @return void
     */
    public function startTestSuite(TestSuite $suite);

    /**
     * @param TestSuite $suite
     * @return void
     */
    public function endTestSuite(TestSuite $suite);

    /**
     * Is invoked once at the very end.
     *
     * @return void
     */
    public function end();
}
