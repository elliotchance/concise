<?php

namespace Concise\Console\ResultPrinter;

use Concise\Core\TestCase;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class DefaultResultPrinterEndTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->e = new Exception();
        $this->test =
            $this->mock('PHPUnit_Framework_TestCase')->stub('getName')->get();
    }

    protected function getTheme()
    {
        return $this->mock('Concise\Console\Theme\DefaultTheme')->stub(
            array(
                'getTheme' => array(
                    PHPUnit_Runner_BaseTestRunner::STATUS_PASSED => 'success_color',
                    PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE => 'failure_color',
                    PHPUnit_Runner_BaseTestRunner::STATUS_ERROR => 'error_color',
                    PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED => 'skipped_color',
                    PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE => 'incomplete_color',
                    PHPUnit_Runner_BaseTestRunner::STATUS_RISKY => 'risky_color',
                )
            )
        )->get();
    }

    public function endTestColorData()
    {
        return array(
            'failure' => array(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                'failure_color'
            ),
            'error' => array(
                PHPUnit_Runner_BaseTestRunner::STATUS_ERROR,
                'error_color'
            ),
            'skipped' => array(
                PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED,
                'skipped_color'
            ),
            'incomplete' => array(
                PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE,
                'incomplete_color'
            ),
            'risky' => array(
                PHPUnit_Runner_BaseTestRunner::STATUS_RISKY,
                'risky_color'
            ),
        );
    }

    /**
     * @dataProvider endTestColorData
     */
    public function testEndTestWillCallAdd($status)
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter',
            array($this->getTheme())
        )
            ->expects('add')
            ->with($status, $this->test, $this->e)
            ->stub('update')
            ->get();
        $resultPrinter->endTest($status, $this->test, 1.23, $this->e);
    }

    public function testEndTestWithUnknownStatusWillNotCallAdd()
    {
        $resultPrinter = $this->niceMock(
            'Concise\Console\ResultPrinter\DefaultResultPrinter',
            array($this->getTheme())
        )->expects('add')->never()->stub('update')->get();
        $resultPrinter->endTest(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED,
            $this->test,
            1.23,
            $this->e
        );
    }
}
