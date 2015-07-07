<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;
use Concise\TestCase;
use Exception;
use PHPUnit_Framework_ExpectationFailedException;
use PHPUnit_Runner_BaseTestRunner;

/**
 * @group cli
 */
class RenderIssueTest extends TestCase
{
    protected $issue;

    protected $test;

    protected $exception;

    public function setUp()
    {
        parent::setUp();
        $this->issue = new RenderIssue();
        $this->test = $this->mock('PHPUnit_Framework_TestCase')->stub(
                array('getName' => 'foo')
            )->get();
        $this->exception = new Exception('foo bar');
    }

    public function testStartsWithTheIssueNumber()
    {
        $this->assert(
            $this->issue->render(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            ),
            starts_with,
            '123. '
        );
    }

    public function testIncludesTestClass()
    {
        $class = get_class($this->test);
        $this->assert(
            $this->issue->render(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            ),
            contains_string,
            $class
        );
    }

    public function testIncludesTheMethodName()
    {
        $this->assert(
            $this->issue->render(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            ),
            contains_string,
            'foo'
        );
    }

    public function testIncludesExceptionMessage()
    {
        $this->assert(
            $this->issue->render(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            ),
            contains_string,
            $this->exception->getMessage()
        );
    }

    protected function getTraceSimplifier($return)
    {
        return $this->mock(
            'Concise\Console\ResultPrinter\Utilities\TraceSimplifier'
        )->expect('render')->andReturn($return)->get();
    }

    protected function render(
        $status = PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
        $issueNumber = 0,
        $text = "foo\nbar"
    ) {
        $simplifier = $this->getTraceSimplifier($text);
        $issue = new RenderIssue($simplifier);

        return $issue->render(
            $status,
            $issueNumber,
            $this->test,
            $this->exception
        );
    }

    public function testWillRenderSimplifiedTraceUnderneathTheTitle()
    {
        $result = $this->render();
        $this->assert($result, contains_string, "foo");
    }

    public function testStackTraceShouldBeRenderedInGrey()
    {
        $result = $this->render();
        $this->assert($result, contains_string, "\033[90mfoo");
    }

    public function testAllStackTraceLinesShouldBeRenderedInGrey()
    {
        $result = $this->render();
        $this->assert($result, contains_string, "\033[90mbar");
    }

    public function testClearFormattingAfterStackTraceToPreventUnwantedTextFromBeingColored(
    )
    {
        $result = $this->render();
        $this->assert($result, contains_string, "bar\033[0m");
    }

    public function testPrefixAllLinesWithAColor()
    {
        $result = $this->render();
        $this->assert($result, contains_string, "\033[41m  \033[0m ");
    }

    public function testPrefixAllLinesWithTheSameColorAsTheTitle()
    {
        $result = $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED);
        $this->assert($result, contains_string, "\033[44m  \033[0m ");
    }

    public function testWhenIssueNumberGoesAbove10ExtraPaddingWillBeProvidedToKeepItAligned(
    )
    {
        $result =
            $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 10);
        $this->assert($result, contains_string, "\033[41m  \033[0m  ");
    }

    public function testTestTitilesAreColored()
    {
        $c = new Color();
        $this->test =
            $this->mock('PHPUnit_Framework_TestCase')->setCustomClassName(
                    'PHPUnit_Framework_TestCase_57c3cc10'
                )->stub(array('getName' => 'foo'))->get();
        $result =
            $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 10);
        $this->assert(
            $result,
            contains_string,
            (string)$c("PHPUnit_Framework_TestCase_57c3cc10::foo")->red()
        );
    }

    public function testCanAcceptATestSuite()
    {
        $this->test = $this->mock('\PHPUnit_Framework_TestSuite')
            ->disableConstructor()
            ->stub(array('getName' => 'foo'))
            ->get();
        $result =
            $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 10);
        $this->assert($result, contains_string, "foo");
    }

    protected function getComparisonFailure()
    {
        // PHPUnit 4.0
        if (class_exists('PHPUnit_Framework_ComparisonFailure')) {
            return 'PHPUnit_Framework_ComparisonFailure';
        }

        // PHPUnit 4.1+
        return 'SebastianBergmann\Comparator\ComparisonFailure';
    }

    public function testPHPUnitDiffsAreShown()
    {
        $failure = $this->mock(
            $this->getComparisonFailure(),
            array('foo', 'bar', 'foo', 'bar')
        )->expect('getDiff')->andReturn('foobar')->get();
        $this->exception =
            new PHPUnit_Framework_ExpectationFailedException('', $failure);

        $result =
            $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 10);
        $this->assert($result, contains_string, "foobar");
    }

    public function testPHPUnitDiffsAreShownOnlyIfAvailable()
    {
        $this->exception =
            new PHPUnit_Framework_ExpectationFailedException('', null);

        $result =
            $this->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 10);
        $this->assert($result, contains_string, "10.");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected integer, but got string for argument 1
     */
    public function testIssueNumberMustBeAnInteger()
    {
        $this->issue->render(
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
            'foo',
            $this->test,
            $this->exception
        );
    }

    public function testNameIsNotAppendedIfItsNotATestCase()
    {
        $renderIssue = $this->niceMock(
            'Concise\Console\ResultPrinter\Utilities\RenderIssue'
        )->expose('getHeading')->get();

        $test = $this->mock('PHPUnit_Framework_Test')->get();

        $this->assert(
            $renderIssue->getHeading(
                PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
                1,
                $test
            ),
            does_not_contain_string,
            '::'
        );
    }

    /**
     * @group #238
     */
    public function testWillRemoveCarriageReturns()
    {
        $result = $this->render(
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE,
            0,
            "foo\n\rbar"
        );
        $this->assert($result, does_not_contain_string, "\r");
    }
}
