<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use Colors\Color;

class ProgressBarTest extends TestCase
{
    public function testOneColorFillUpEntireBar()
    {
        $c = new Color();
        $progressBar = new ProgressBar();
        $result = $progressBar->render(5, array(
            'green' => 5
        ));
        $this->assert($result, equals, $c('     ')->bg_green);
    }
}
