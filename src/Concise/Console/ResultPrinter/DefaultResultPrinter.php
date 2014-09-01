<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Exception;
use PHPUnit_Framework_Test;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinter extends AbstractResultPrinter
{
    protected $width;

    protected $theme;

    protected $issueNumber = 1;

    public function __construct($theme = null)
    {
        $this->width = exec('tput cols');
        if (!$theme) {
            $theme = new DefaultTheme();
        }
        $this->theme = $theme;
    }

    public function end()
    {
        $this->write("\n\n\n");
    }

    protected function add($status, PHPUnit_Framework_Test $test, Exception $e = null)
    {
    }

    public function endTest($status, PHPUnit_Framework_Test $test, $time, Exception $e = null)
    {
        if ($status !== PHPUnit_Runner_BaseTestRunner::STATUS_PASSED) {
            $this->add($status, $test, $e);
        }
        ++$this->issueNumber;
    }
}
