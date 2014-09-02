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

    public function testPercentageCanBeActivatedWithConstructor()
    {
        $counter = new ProgressCounter(5, true);
        $this->assert($counter->render(5), equals, '5 / 5 (100%)');
    }

    public function testPercentageIsCalculatedBasedOnValue()
    {
        $counter = new ProgressCounter(10, true);
        $this->assert($counter->render(5), equals, '5 / 10 ( 50%)');
    }

    public function testPercentageIsAlwaysShownAsAWholeNumber()
    {
        $counter = new ProgressCounter(9, true);
        $this->assert($counter->render(5), equals, '5 / 9 ( 55%)');
    }

    public function testPercentageMayBeOneDigit()
    {
        $counter = new ProgressCounter(100, true);
        $this->assert($counter->render(5), equals, '5 / 100 (  5%)');
    }

    public function testDivideByZeroWillYieldZeroPercent()
    {
        $counter = new ProgressCounter(0, true);
        $this->assert($counter->render(0), equals, '0 / 0 (  0%)');
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Total must be at least zero.
     */
    public function testTotalMustBeAtLeastZero()
    {
        new ProgressCounter(-1);
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Value must be at least zero.
     */
    public function testValueMustBeAtLeastZero()
    {
        $counter = new ProgressCounter(0);
        $counter->render(-1);
    }

    public function testValueGreaterThanTotalWillCreateNewTotal()
    {
        $counter = new ProgressCounter(10);
        $this->assert($counter->render(15), equals, '15 / 15');
    }

    public function testPercentageMaximumValueIs100()
    {
        $counter = new ProgressCounter(10, true);
        $this->assert($counter->render(15), equals, '15 / 15 (100%)');
    }
}
