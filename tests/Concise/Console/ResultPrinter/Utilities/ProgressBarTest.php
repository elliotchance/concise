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
        $c = new Color();
        $result = $this->progressBar->render(5, array(
            'green' => 5,
        ));
        $this->assert($result, equals, $c('     ')->bg_green);
    }

    public function testTwoColors()
    {
        $c = new Color();
        $result = $this->progressBar->render(6, array(
            'green' => 3,
            'red'   => 3,
        ));
        $this->assert($result, equals, (string) $c('   ')->highlight('green') . (string) $c('   ')->highlight('red'));
    }

    public function testPartsMustBeProportionalToTheTotal()
    {
        $c = new Color();
        $result = $this->progressBar->render(5, array(
            'green' => 60,
            'red'   => 40,
        ));
        $this->assert($result, equals, (string) $c('   ')->highlight('green') . (string) $c('  ')->highlight('red'));
    }

    public function testPartsAreNotAlwaysCleanlyDivisible()
    {
        $c = new Color();
        $result = $this->progressBar->render(5, array(
            'green' => 4,
            'red'   => 7,
        ));
        $this->assert($result, equals, (string) $c(' ')->highlight('green') . (string) $c(' ')->highlight('green') . (string) $c('   ')->highlight('red'));
    }
}
