<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Exception;
use PHPUnit_Framework_Test;

class DefaultResultPrinter extends AbstractResultPrinter
{
    protected $width;

    protected $theme;

    public function __construct()
    {
        $this->width = exec('tput cols');
        $this->theme = new DefaultTheme();
    }

    public function end()
    {
        $this->write("\n\n\n");
    }

    protected function add(PHPUnit_Framework_Test $test, $color, Exception $e = null)
    {
    }

    public function endTest($status, PHPUnit_Framework_Test $test, $time, Exception $e = null)
    {
        $colors = $this->theme->getTheme();
        $this->add($test, $colors['failure'], $e);
    }
}
