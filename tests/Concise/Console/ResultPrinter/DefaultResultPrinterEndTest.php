<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;
use Concise\Console\Theme\DefaultTheme;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinterEndTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->e = new Exception();
        $this->test = $this->mock('PHPUnit_Framework_Test')->done();
    }

    protected function getTheme()
    {
        return $this->mock('Concise\Console\Theme\DefaultTheme')
                    ->stub(array('getTheme' => array(
                        'success'    => 'success_color',
                        'failure'    => 'failure_color',
                        'error'      => 'error_color',
                        'skipped'    => 'skipped_color',
                        'incomplete' => 'incomplete_color',
                        'risky'      => 'risky_color',
                    )))
                    ->done();
    }

    public function endTestColorData()
    {
        return array(
            'failure' => array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 'failure_color'),
            'error'   => array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR, 'error_color'),
            'skipped' => array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED, 'skipped_color'),
        );
    }

    /**
     * @dataProvider endTestColorData
     */
    public function testEndTestWillCallAdd($status, $color)
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter', [ $this->getTheme() ])
                              ->expects('add')->with($this->test, $color, $this->e)
                              ->done();
        $resultPrinter->endTest($status, $this->test, 1.23, $this->e);
    }
}
