<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\ResultPrinter\Utilities\ProgressCounter;
use Concise\Core\TestCase;
use Concise\Mock\Invocation;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinterStub extends DefaultResultPrinter
{
    public function getWidth()
    {
        return $this->width;
    }

    public function getIssueNumber()
    {
        return $this->issueNumber;
    }

    public function update()
    {
    }

    public function write($buffer)
    {
    }
}

/**
 * @group ci
 */
class DefaultResultPrinterTest extends TestCase
{
    /**
     * @var DefaultResultPrinterStub
     */
    protected $resultPrinter;

    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = new DefaultResultPrinterStub();
    }

    public function testWillGetConsoleWidthOnStartup()
    {
        $this->assert($this->resultPrinter->getWidth())
            ->equals(exec('tput cols'));
    }

    public function testFirstIssueNumberIsOne()
    {
        $this->assert($this->resultPrinter->getIssueNumber())->equals(1);
    }

    public function testEndTestWillIncrementIssueNumber()
    {
        $test = $this->mock('PHPUnit_Framework_TestCase')->stub(
            array('getName' => '')
        )->get();
        $exception = $this->mock('Exception')->get();
        $this->resultPrinter->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
            $test,
            0,
            $exception
        );
        $this->assert($this->resultPrinter->getIssueNumber())->equals(2);
    }

    public function testEndTestWillNotIncrementIssueNumberOnSuccess()
    {
        $test = $this->mock('PHPUnit_Framework_TestCase')->stub(
            array('getName' => '')
        )->get();
        $this->resultPrinter->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED,
            $test,
            0,
            null
        );
        $this->assert($this->resultPrinter->getIssueNumber())->equals(1);
    }

    public function testEndTestWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expects('update')->get();
        $test = $this->mock('PHPUnit_Framework_TestCase')->stub(
            array('getName' => '')
        )->get();
        $resultPrinter->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED,
            $test,
            0,
            null
        );
    }

    public function testUpdateWillPrintProgress()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('update')->expect('write')->stub('restoreCursor')->get();
        $resultPrinter->update();
    }

    public function testStartSuiteWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expects('update')->get();
        $suite = $this->niceMock('PHPUnit_Framework_TestSuite')->stub(
            array('getName' => '')
        )->get();
        $resultPrinter->startTestSuite($suite);
    }

    public function testEndWillUpdateProgress()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expects('update')->stub('write')->get();
        $resultPrinter->end();
    }

    public function verboseDataSet()
    {
        $show = 1;
        $hide = 0;

        return array(
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, true, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, false, $hide),
            array(
                PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE,
                true,
                $show
            ),
            array(
                PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE,
                false,
                $hide
            ),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, true, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, false, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR, true, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR, false, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY, true, $show),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY, false, $hide),
        );
    }

    /**
     * @dataProvider verboseDataSet
     */
    public function testVerbosePrintsIssues($status, $isVerbose, $willBePrinted)
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )
            ->expect('appendTextAbove')
            ->exactly($willBePrinted)
            ->expose('add')
            ->get();
        $resultPrinter->setVerbose($isVerbose);
        $test = $this->niceMock('PHPUnit_Framework_TestCase')->stub(
            array('getName' => '')
        )->get();
        $resultPrinter->add($status, $test, new Exception());
    }

    public function testStartTimeIsNow()
    {
        $this->assert($this->getProperty($this->resultPrinter, 'startTime'))
            ->isWithin(1)->of(time());
    }

    public function testAssertionStringIncludesTheRunTime()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->get();

        $this->assertString($resultPrinter->getAssertionString())
            ->contains('0 seconds');
    }

    public function testWillPrintCorrectTimeElapsed()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 10);

        $this->assertString($resultPrinter->getAssertionString())
            ->contains('10 seconds');
    }

    public function testUsesTimeFormatter()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 200);

        $this->assertString($resultPrinter->getAssertionString())
            ->contains('3 minutes 20 seconds');
    }

    public function testHasUpdatedIsFalseByDefault()
    {
        $this->assert(
            $this->getProperty($this->resultPrinter, 'hasUpdated')
        )->isFalse;
    }

    public function testHasUpdatedIsTrueAfterUpdateIsCalled()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->get();
        $resultPrinter->update();
        $this->assert(
            $this->getProperty($resultPrinter, 'hasUpdated')
        )->isTrue;
    }

    public function testWillRestoreCursorWithUpdate()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->expect('restoreCursor')->get();
        $resultPrinter->update();
        $resultPrinter->update();
    }

    public function testWillNotRestoreCursorWithFirstUpdate()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->expect('restoreCursor')->never()->get();
        $resultPrinter->update();
    }

    public function testAppendTextAboveMustRestoreTheCursorAlways()
    {
        /** @var $resultPrinter \Concise\Console\ResultPrinter\DefaultResultPrinter */
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->stub('write')->stub('update')->expect('restoreCursor')->get();
        $resultPrinter->appendTextAbove('');
    }

    public function testWillShowEstimate()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 25)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 60);

        $this->assertString($resultPrinter->getAssertionString())
            ->contains(' remaining');
    }

    public function testWillShowAccurateEstimate()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 25)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 60);

        $this->assertString($resultPrinter->getAssertionString())
            ->contains(' (3 minutes remaining)');
    }

    public function testWillNotShowEstimateIfETAIsZero()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 100)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 60);

        $this->assertString($resultPrinter->getAssertionString())
            ->doesNotContain(' remaining');
    }

    public function testWillNotShowEstimateUntil5SecondsHaveElapsed()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 25)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 3);

        $this->assertString($resultPrinter->getAssertionString())
            ->doesNotContain(' remaining');
    }

    public function testWillShowEstimateOnce5SecondsHaveElapsed()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getAssertionString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 25)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 5);

        $this->assertString($resultPrinter->getAssertionString())
            ->contains(' remaining');
    }

    /**
     * @group #228
     */
    public function testWillNotRefreshEstimatedTimeMoreThanOncePerSecond()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getRemainingTimeString')->stub(
            array('getTotalTestCount' => 100, 'getTestCount' => 25)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 5);
        $a = $resultPrinter->getRemainingTimeString();
        $this->setProperty($resultPrinter, 'startTime', time() - 10);
        $b = $resultPrinter->getRemainingTimeString();

        $this->assert($a)->equals($b);
    }

    /**
     * @group #239
     */
    public function testCanOutputShortenedAssertionString()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )->expose('getRealAssertionString')->stub(
            array('getTotalTestCount' => 1000, 'getTestCount' => 200)
        )->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 4000);
        $this->setProperty($resultPrinter, 'width', 80);

        $this->assertString($resultPrinter->getRealAssertionString(false))
            ->isEmpty;
    }

    /**
     * @group #239
     * @group #129
     */
    public function testWillUseShorterAssertionStringIfRequired()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )
            ->expose('getAssertionString')
            ->stub('getRealAssertionString')
            ->andReturnCallback(
                function (Invocation $invocation) {
                    return $invocation->getArgument(0) ? 'foo' : '';
                }
            )
            ->get();
        $this->setProperty($resultPrinter, 'startTime', time() - 4000);
        $this->setProperty($resultPrinter, 'width', 80);

        $this->assert($resultPrinter->getAssertionString())->equals('foo');
    }

    /**
     * @group #276
     */
    public function testThereIsOneSpaceBetweenTheTimeAndProgress()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter'
        )
            ->expose('getAssertionString')
            ->stub(
                array(
                    'getTotalTestCount' => 2778,
                    'getTestCount' => 834,
                    'getSecondsElapsed' => 500,
                    'getRemainingSeconds' => 1165,
                    'getAssertionCount' => 1910,
                )
            )
            ->get();
        $this->setProperty($resultPrinter, 'width', 80);
        $this->setProperty(
            $resultPrinter,
            'counter',
            new ProgressCounter(2778, true)
        );

        $this->assertString($resultPrinter->getAssertionString())
            ->doesNotContain(')8');
    }
}
