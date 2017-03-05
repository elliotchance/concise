<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;

class ProgressBarTest extends ProgressBarTestCase
{
    /**
     * @var ProgressBar
     */
    protected $progressBar;

    public function setUp()
    {
        parent::setUp();
        $this->progressBar = new ProgressBar();
    }

    public function testOneColorFillUpEntireBar()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::GREEN => 5,
            )
        );
        $this->assert($result)->equals($this->color(5, ThemeColor::GREEN));
    }

    public function testTwoColors()
    {
        $result = $this->progressBar->render(
            6,
            array(
                ThemeColor::GREEN => 3,
                ThemeColor::RED => 3,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(3, ThemeColor::GREEN) .
                $this->color(3, ThemeColor::RED)
            );
    }

    public function testPartsMustBeProportionalToTheTotal()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::GREEN => 60,
                ThemeColor::RED => 40,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(3, ThemeColor::GREEN) .
                $this->color(2, ThemeColor::RED)
            );
    }

    public function testPartsAreNotAlwaysCleanlyDivisible()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::GREEN => 4,
                ThemeColor::RED => 7,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(1, ThemeColor::GREEN) .
                $this->color(4, ThemeColor::RED)
            );
    }

    public function testLessThanOneBarWillAlwaysShowOneBar()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::YELLOW => 1,
                ThemeColor::BLUE => 19,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(1, ThemeColor::YELLOW) .
                $this->color(4, ThemeColor::BLUE)
            );
    }

    public function testZeroIsAllowed()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::YELLOW => 0,
                ThemeColor::BLUE => 19,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(0, ThemeColor::YELLOW) .
                $this->color(5, ThemeColor::BLUE)
            );
    }

    public function testNegativeValuesAreAllowed()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::YELLOW => -5,
                ThemeColor::BLUE => 19,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(0, ThemeColor::YELLOW) .
                $this->color(5, ThemeColor::BLUE)
            );
    }

    public function testTotalIsZero()
    {
        $result = $this->progressBar->render(
            5,
            array(
                ThemeColor::YELLOW => 1,
                ThemeColor::BLUE => -1,
            )
        );
        $this->assert($result)
            ->equals(
                $this->color(0, ThemeColor::YELLOW) .
                $this->color(0, ThemeColor::BLUE)
            );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected integer, but got string for argument 1
     */
    public function testSizeMustBeAnInteger()
    {
        $this->progressBar->render('abc', array());
    }
}
