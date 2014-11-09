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

    public function __construct(DefaultTheme $theme = null)
    {
        $this->width = (int) exec('tput cols');
        if (!$theme) {
            $theme = new DefaultTheme();
        }
        $this->theme = $theme;
        $this->counter = new ProgressCounter(0, true);
        $this->startTime = time();
    }

    public function end()
    {
        $this->update();
        $this->write("\n\n\n");
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

    protected function getAssertionString()
    {
        $assertionString = $this->getAssertionCount() . ' assertion' . ($this->getAssertionCount() == 1 ? '' : 's');
        $formatter = new TimeFormatter();
        $time = ', ' . $formatter->format(time() - $this->startTime);
        $counterString = $this->counter->render($this->getTestCount());
        $pad = $this->width - strlen($assertionString) - strlen($counterString) - strlen($time);

        return sprintf("%s%s%s%s\n", $assertionString, $time, str_repeat(' ', $pad), $counterString);
    }

    public function update()
    {
        $this->write($this->getAssertionString() . $this->drawProgressBar() . "\033[2F");
    }

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
        $this->appendTextAbove("$message\n\n");
        ++$this->issueNumber;
    }

    public function appendTextAbove($text)
    {
        $this->write(str_replace("\n", "\033[K\n", $text));
        $this->update();
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        parent::startTestSuite($suite);
        $this->counter = new ProgressCounter($this->getTotalTestCount(), true);
        $this->update();
    }
}
