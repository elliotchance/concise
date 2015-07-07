<?php

namespace Concise\Console\TestRunner;

use Exception;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

interface TestResultDelegateInterface
{
    /**
     * @param int                    $status A status constant from PHPUnit_Runner_BaseTestRunner
     * @param PHPUnit_Framework_Test $test The test that just finished.
     * @param float                  $time The number of seconds the test took to execute.
     * @param Exception              $e The error (applies to all statuses except
     *     STATUS_PASSED)
     * @return void
     */
    public function endTest(
        $status,
        PHPUnit_Framework_Test $test,
        $time,
        Exception $e = null
    );

    /**
     * @param PHPUnit_Framework_TestSuite $suite
     * @return void
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite);

    /**
     * @param PHPUnit_Framework_TestSuite $suite
     * @return void
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite);

    /**
     * Is invoked once at the very end.
     *
     * @return void
     */
    public function end();
}
