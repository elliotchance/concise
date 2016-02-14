<?php

namespace Concise\Extensions\Pho;

use Concise\Core\TestCase;
use Concise\Core\VirtualTestSuiteInterface;
use pho\Console\Console;
use pho\Reporter\ConciseReporter;
use pho\Runner\Runner;
use PHPUnit_Framework_TestResult;

class PhoTestCase extends TestCase implements VirtualTestSuiteInterface
{
    public static $count = 0;

    public function test()
    {
    }

    public function count()
    {
        return 1;
    }

    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        if ($result === null) {
            $result = $this->createResult();
        }

        ConciseReporter::$test = $this;
        ConciseReporter::$testCase = new TestCase();
        ConciseReporter::$result = $result;

        // Create a new Console and parse arguments
        $console = new Console(
            array('--reporter', 'concise'),
            'php://stdout'
        );
        $console->parseArguments();

        // Start the runner
        Runner::$console = $console;
        Runner::getInstance()->run();

        return $result;
    }

    public function getRealCount()
    {
        return self::$count;
    }
}
