<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Exception;
use PHPUnit_Runner_BaseTestRunner;
use Concise\Console\ResultPrinter\Utilities\ProportionalProgressBar;
use Concise\Console\ResultPrinter\Utilities\ProgressCounter;
use Concise\Console\ResultPrinter\Utilities\RenderIssue;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

class DefaultResultPrinter extends AbstractResultPrinter
{
    protected $width;

    protected $theme;

    protected $issueNumber = 1;

    protected $counter;

    public function __construct($theme = null)
    {
        $this->width = exec('tput cols');
        if (!$theme) {
            $theme = new DefaultTheme();
        }
        $this->theme = $theme;
        $this->counter = new ProgressCounter(0, true);
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
            ++$this->issueNumber;
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
        $counterString = $this->counter->render($this->getTestCount());
        $pad = $this->width - strlen($assertionString) - strlen($counterString);

        return sprintf("%s%s%s\n", $assertionString, str_repeat(' ', $pad), $counterString);
    }

    public function update()
    {
        $this->write($this->getAssertionString() . $this->drawProgressBar() . "\033[2F");
    }

    protected function add($status, PHPUnit_Framework_Test $test, Exception $e)
    {
        $renderIssue = new RenderIssue();
        $message = $renderIssue->render($status, $this->issueNumber, $test, $e);
        $this->appendTextAbove("$message\n\n");
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
