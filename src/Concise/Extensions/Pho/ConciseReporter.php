<?php

namespace Concise\Extensions\Pho;

use Concise\Core\TestCase;
use pho\Reporter\AbstractReporter;
use pho\Reporter\ReporterInterface;
use pho\Runnable\Spec;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestResult;
use PHPUnit_Framework_TestSuite;

class ConciseReporter extends AbstractReporter implements ReporterInterface
{
    /**
     * @var TestCase
     */
    public static $testCase = null;

    /**
     * @var PHPUnit_Framework_TestResult
     */
    public static $result = null;

    /**
     * @var PHPUnit_Framework_Test
     */
    public static $test = null;

    /**
     * @var PHPUnit_Framework_TestSuite
     */
    public static $testSuite = null;

    public function beforeRun()
    {
        parent::beforeRun();
        TestCase::setUpBeforeClass();
    }

    public function beforeSpec(Spec $spec)
    {
        self::$testCase->setUp();
        self::$result->startTest(self::$test);
    }

    public function afterSpec(Spec $spec)
    {
        if ($spec->isFailed()) {
            $this->failedSpecs[] = $spec;
            self::$result->addFailure(
                self::$test,
                new \PHPUnit_Framework_AssertionFailedError(
                    $spec->exception
                ),
                5
            );
        } elseif ($spec->isIncomplete()) {
            $this->incompleteSpecs[] = $spec;
            $incomplete = $this->formatter->cyan('I');
            $this->console->write($incomplete);
        } elseif ($spec->isPending()) {
            $this->pendingSpecs[] = $spec;
            $pending = $this->formatter->yellow('P');
            $this->console->write($pending);
        }

        self::$testCase->tearDown();
        self::$result->endTest(self::$test, 1);
    }

    /**
     * Invoked after the test suite has ran, allowing for the display of
     * test results and related statistics.
     */
    public
    function afterRun()
    {
        TestCase::tearDownAfterClass();
        //self::$result->endTestSuite(self::$testSuite);
        //parent::afterRun();
    }
}
