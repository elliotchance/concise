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
                        'success'    => 'success',
                        'failure'    => 'failure',
                        'error'      => 'error',
                        'skipped'    => 'skipped',
                        'incomplete' => 'incomplete',
                        'risky'      => 'risky',
                    )))
                    ->done();
    }

    public function testEndTestFailureWillCallAdd()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter', [ $this->getTheme() ])
                              ->expects('add')->with($this->test, 'failure', $this->e)
                              ->done();
        $resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, $this->test, 1.23, $this->e);
    }

    public function testEndTestErrorWillCallAdd()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\DefaultResultPrinter', [ $this->getTheme() ])
                              ->expects('add')->with($this->test, 'error', $this->e)
                              ->done();
        $resultPrinter->endTest(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR, $this->test, 1.23, $this->e);
    }
}
