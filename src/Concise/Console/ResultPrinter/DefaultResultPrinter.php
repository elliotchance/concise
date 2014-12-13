<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Concise\Services\TimeFormatter;
use Exception;
use PHPUnit_Runner_BaseTestRunner;
use Concise\Console\ResultPrinter\Utilities\ProportionalProgressBar;
use Concise\Console\ResultPrinter\Utilities\ProgressCounter;
use Concise\Console\ResultPrinter\Utilities\RenderIssue;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

class DefaultResultPrinter extends AbstractResultPrinter
{
    /**
     * @var integer
     */
    protected $width;

    /**
     * @var DefaultTheme
     */
    protected $theme;

    /**
     * @var integer
     */
    protected $issueNumber = 1;

    /**
     * @var ProgressCounter
     */
    protected $counter;

    /**
     * @var integer
     */
    protected $startTime;

    /**
     * @var bool
     */
    protected $hasUpdated = false;

    /**
     * @var integer
     */
    protected $lastUpdatedRemainingSecondsAt = 0;

    /**
     * @var string
     */
    protected $remainingSecondsString = '';

    /**
     * @var TimeFormatter
     */
    protected $formatter;

    public function __construct(DefaultTheme $theme = null)
    {
        /** @noinspection SpellCheckingInspection */
        $this->width = (int) exec('tput cols');
        if (!$theme) {
            $theme = new DefaultTheme();
        }
        $this->theme = $theme;
        $this->counter = new ProgressCounter(0, true);
        $this->startTime = time();
        $this->formatter = new TimeFormatter();
    }

    public function end()
    {
        $this->update();
    }

    public function endTest($status, PHPUnit_Framework_Test $test, $time, Exception $e = null)
    {
        if ($status !== PHPUnit_Runner_BaseTestRunner::STATUS_PASSED) {
            $this->add($status, $test, $e);
        }
        $this->update();
    }

    protected function drawProgressBar()
    {
        $progressBar = new ProportionalProgressBar();

        return $progressBar->renderProportional($this->width, $this->getTotalTestCount(), array(
            'green'   => $this->getSuccessCount(),
            'yellow'  => $this->getIncompleteCount() + $this->getRiskyCount(),
            'blue'    => $this->getSkippedCount(),
            'red'     => $this->getFailureCount() + $this->getErrorCount(),
        )) . "\n";
    }

    protected function getSecondsElapsed()
    {
        return time() - $this->startTime;
    }

    protected function getRemainingSeconds()
    {
        $testCount = $this->getTestCount();
        if (0 == $testCount) {
            return -1;
        }
        $elapsed = $this->getSecondsElapsed();
        $eta = ($this->getTotalTestCount() / $testCount) * $elapsed - $elapsed;
        return $eta;
    }

    protected function getRemainingTimeString($short = false)
    {
        if ($this->lastUpdatedRemainingSecondsAt == time()) {
            return $this->remainingSecondsString;
        }

        $remainingSeconds = $this->getRemainingSeconds();
        $this->remainingSecondsString = '';
        if ($this->getSecondsElapsed() >= 5 && $remainingSeconds >= 1) {
            $this->remainingSecondsString = ' (' . $this->formatter->format($remainingSeconds, $short) . ' remaining)';
        }

        $this->lastUpdatedRemainingSecondsAt = time();
        return $this->remainingSecondsString;
    }

    /**
     * @param bool $short
     * @return string
     */
    protected function getRealAssertionString($short)
    {
        $assertionString = $this->getAssertionCount() . ' assertion' .
            ($this->getAssertionCount() == 1 ? '' : 's');
        $time = ', ' . $this->formatter->format($this->getSecondsElapsed(), $short);
        $remaining = $this->getRemainingTimeString($short);
        $counterString = $this->counter->render($this->getTestCount(), $short);
        $pad = $this->width - strlen($assertionString) - strlen($counterString) - strlen($time) -
            strlen($remaining);

        if ($pad < 0) {
            return '';
        }
        return sprintf("%s%s%s%s%s\n", $assertionString, $time, $remaining, str_repeat(' ', $pad),
            $counterString);
    }

    protected function getAssertionString()
    {
        $assertionString = $this->getRealAssertionString(false);
        if (!$assertionString) {
            $assertionString = $this->getRealAssertionString(true);
        }
        return $assertionString;
    }

    protected function restoreCursor()
    {
        $this->write("\033[3F");
    }

    public function update()
    {
        if ($this->hasUpdated) {
            $this->restoreCursor();
        }
        $this->write($this->getAssertionString() . $this->drawProgressBar() . "\n");
        $this->hasUpdated = true;
    }

    /**
     * @param integer $status
     */
    protected function add($status, PHPUnit_Framework_Test $test, Exception $e)
    {
        switch ($status) {
            case PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED:
            case PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE:
            case PHPUnit_Runner_BaseTestRunner::STATUS_RISKY:
                if (!$this->isVerbose()) {
                    return;
                }
        }

        $renderIssue = new RenderIssue();
        $message = $renderIssue->render($status, $this->issueNumber, $test, $e);
        $this->appendTextAbove($message);
        ++$this->issueNumber;
    }

    public function appendTextAbove($text)
    {
        $this->restoreCursor();
        $this->write(str_replace("\n", "\033[K\n", $text) . "\n\n\n\n\n");
        $this->update();
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        parent::startTestSuite($suite);
        $this->counter = new ProgressCounter($this->getTotalTestCount(), true);
        $this->update();
    }
}
