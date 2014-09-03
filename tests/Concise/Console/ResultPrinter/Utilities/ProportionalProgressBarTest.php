<?php

namespace Concise\Console\ResultPrinter\Utilities;

class ProportionalProgressBarTest extends ProgressBarTestCase
{
    public function testAProportionalProgressBarWillScaleDownAndFillToTheTotalWidth()
    {
        $progressBar = new ProportionalProgressBar();
        $result = $progressBar->renderProportional(10, 40, array(
            'yellow' => 1,
            'blue'   => 19,
        ));
        $this->assert($result, equals, $this->color(1, 'yellow') . $this->color(4, 'blue') . '_____');
    }

    public function testZeroTotalMeans100Percent()
    {
        $progressBar = new ProportionalProgressBar();
        $result = $progressBar->renderProportional(10, 40, array(
            'yellow' => 1,
            'blue'   => 19,
        ));
        $this->assert($result, equals, $this->color(1, 'yellow') . $this->color(4, 'blue') . '_____');
    }

    public function testNoPartsMeansZeroPercent()
    {
        $progressBar = new ProportionalProgressBar();
        $result = $progressBar->renderProportional(10, 0, array());
        $this->assert($result, equals, '__________');
    }
}
