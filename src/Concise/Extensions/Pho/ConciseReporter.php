<?php

namespace Concise\Extensions\Pho;

use Closure;
use Concise\Core\TestCase;
use pho\Reporter\AbstractReporter;
use pho\Reporter\ReporterInterface;
use pho\Runnable\Spec;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_IncompleteTestError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestResult;
use PHPUnit_Framework_TestSuite;

/**
 * We use a cusom reporter for Pho as the trigger to setup and tear down the
 * unit test-like environment.
 *
 * Due to the way Pho specs must be reconstructed in an xUnit style most of the
 * state is kept statically as it is aggregated along the way since there is
 * only one possibel runner when the suite begins.
 */
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

    /**
     * The before run is used to start the test suite. It will contain many test
     * cases.
     */
    public function beforeRun()
    {
        parent::beforeRun();
        TestCase::setUpBeforeClass();
    }

    /**
     * Before executing an it() spec it should be setup like a test case.
     *
     * @param Spec $spec
     */
    public function beforeSpec(Spec $spec)
    {
        self::$testCase->setUp();
        self::$result->startTest(self::$test);

        /** @var Closure $closure */
        $closure = self::$testCase->getProperty($spec, 'closure');

        // This will not be set for incomplete specs.
        if (!$closure) {
            return;
        }
        $suite = self::$testCase->getProperty($spec, 'suite');
        $newSuite = new ProxySuite($spec->getTitle(), $closure, $suite);
        $reflection = new \ReflectionClass($suite);
        foreach ($reflection->getProperties() as $property) {
            $v = self::$testCase->getProperty($suite, $property->getName());
            self::$testCase->setProperty($newSuite, $property->getName(), $v);
        }
        /** @noinspection PhpUndefinedMethodInspection */
        $closure = $closure->bindTo($newSuite);
        self::$testCase->setProperty($spec, 'closure', $closure);
    }

    /**
     * After an it() spec we need to tear down the test case.
     *
     * @param Spec $spec
     */
    public function afterSpec(Spec $spec)
    {
        $time = 0;
        if ($spec->isFailed()) {
            self::$result->addFailure(
                self::$test,
                new PHPUnit_Framework_AssertionFailedError(
                    $spec->exception
                ),
                $time
            );
        } elseif ($spec->isIncomplete()) {
            self::$result->addFailure(
                self::$test,
                new PHPUnit_Framework_IncompleteTestError(
                    $spec->exception
                ),
                $time
            );
        }

        self::$testCase->tearDown();
        self::$result->endTest(self::$test, $time);
    }

    /**
     * Invoked after the test suite has ran, allowing for the display of
     * test results and related statistics.
     */
    public function afterRun()
    {
        TestCase::tearDownAfterClass();
    }
}
