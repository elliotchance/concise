<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class ProgressCounterTest extends TestCase
{
    public function testCounterStartsAtZero()
    {
        $counter = new ProgressCounter(1);
        $this->assert($counter->render(), equals, '0 / 1');
    }

    public function testCounterTotalIsSetThroughTheConstructor()
    {
        $counter = new ProgressCounter(5);
        $this->assert($counter->render(), equals, '0 / 5');
    }

    public function testRenderCanTakeANumber()
    {
        $counter = new ProgressCounter(5);
        $this->assert($counter->render(3), equals, '3 / 5');
    }
}
