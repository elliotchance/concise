<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;
use Colors\Color;

class ProgressBarTest extends TestCase
{
    protected $progressBar;

    public function setUp()
    {
        parent::setUp();
        $this->progressBar = new ProgressBar();
    }

    public function testOneColorFillUpEntireBar()
    {
        $result = $this->progressBar->render(5, array(
            'green' => 5,
        ));
        $this->assert($result, equals, $this->color(5, 'green'));
    }

    public function testTwoColors()
    {
        $result = $this->progressBar->render(6, array(
            'green' => 3,
            'red'   => 3,
        ));
        $this->assert($result, equals, $this->color(3, 'green') . $this->color(3, 'red'));
    }

    public function testPartsMustBeProportionalToTheTotal()
    {
        $result = $this->progressBar->render(5, array(
            'green' => 60,
            'red'   => 40,
        ));
        $this->assert($result, equals, $this->color(3, 'green') . $this->color(2, 'red'));
    }

    public function testPartsAreNotAlwaysCleanlyDivisible()
    {
        $result = $this->progressBar->render(5, array(
            'green' => 4,
            'red'   => 7,
        ));
        $this->assert($result, equals, $this->color(1, 'green') . $this->color(4, 'red'));
    }

    public function testLessThanOneBarWillAlwaysShowOneBar()
    {
        $result = $this->progressBar->render(5, array(
            'yellow' => 1,
            'blue'   => 19,
        ));
        $this->assert($result, equals, $this->color(1, 'yellow') . $this->color(4, 'blue'));
    }

    protected function color($size, $color)
    {
        $c = new Color();

        return (string) $c(str_repeat(' ', $size))->highlight($color);
    }
}
