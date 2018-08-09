<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;
use Concise\Core\TestCase;
use DateTime;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Runner\BaseTestRunner;
use SebastianBergmann\Comparator\ComparisonFailure;

/**
 * @group cli
 */
class RenderIssueTest extends TestCase
{
    /**
     * @var RenderIssue
     */
    protected $issue;

    protected $test;

    /**
     * @var Exception
     */
    protected $exception;

    public function setUp()
    {
        parent::setUp();
        $this->issue = new RenderIssue();
        $this->test = $this->mock(TestCase::class)->stub(
            array('getName' => 'foo')
        )->get();
        $this->exception = new Exception('foo bar');
    }

    public function testStartsWithTheIssueNumber()
    {
        $this->assertString(
            $this->issue->render(
                BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            )
        )->startsWith('123. ');
    }

    public function testIncludesTestClass()
    {
        $class = get_class($this->test);
        $this->assertString(
            $this->issue->render(
                BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            )
        )->contains($class);
    }

    public function testIncludesTheMethodName()
    {
        $this->assertString(
            $this->issue->render(
                BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            )
        )->contains('foo');
    }

    public function testIncludesExceptionMessage()
    {
        $this->assertString(
            $this->issue->render(
                BaseTestRunner::STATUS_FAILURE,
                123,
                $this->test,
                $this->exception
            )
        )->contains($this->exception->getMessage());
    }

    protected function getTraceSimplifier($return)
    {
        return $this->mock(
            'Concise\Console\ResultPrinter\Utilities\TraceSimplifier'
        )->expect('render')->andReturn($return)->get();
    }

    protected function render(
        $status = BaseTestRunner::STATUS_FAILURE,
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
        $this->assertString($result)->contains("foo");
    }

    public function testStackTraceShouldBeRenderedInGrey()
    {
        $result = $this->render();
        $this->assertString($result)->contains("\033[90mfoo");
    }

    public function testAllStackTraceLinesShouldBeRenderedInGrey()
    {
        $result = $this->render();
        $this->assertString($result)->contains("\033[90mbar");
    }

    public function testClearFormattingAfterStackTraceToPreventUnwantedTextFromBeingColored(
    )
    {
        $result = $this->render();
        $this->assertString($result)->contains("bar\033[0m");
    }

    public function testPrefixAllLinesWithAColor()
    {
        $result = $this->render();
        $this->assertString($result)->contains("\033[41m  \033[0m ");
    }

    public function testPrefixAllLinesWithTheSameColorAsTheTitle()
    {
        $result = $this->render(BaseTestRunner::STATUS_SKIPPED);
        $this->assertString($result)->contains("\033[44m  \033[0m ");
    }

    public function testWhenIssueNumberGoesAbove10ExtraPaddingWillBeProvidedToKeepItAligned(
    )
    {
        $result = $this->render(BaseTestRunner::STATUS_FAILURE, 10);
        $this->assertString($result)->contains("\033[41m  \033[0m  ");
    }

    public function testTestTitilesAreColored()
    {
        $c = new Color();
        $this->test = $this->mock(DateTime::class)->setCustomClassName(
            'DateTime_57c3cc10'
        )->stub(array('format' => 'foo'))->get();
        $result =
            $this->render(BaseTestRunner::STATUS_FAILURE, 10);
        $this->assertString($result)->contains(
            (string)$c("DateTime_57c3cc10::foo")->red()
        );
    }

    public function testCanAcceptATestSuite()
    {
        $this->test = $this->mock(TestSuite::class)
            ->disableConstructor()
            ->stub(array('getName' => 'foo'))
            ->get();
        $result = $this->render(
            BaseTestRunner::STATUS_FAILURE,
            10
        );
        $this->assertString($result)->contains("foo");
    }

    public function testPHPUnitDiffsAreShown()
    {
        $failure = $this->mock(
            ComparisonFailure::class,
            array('foo', 'bar', 'foo', 'bar')
        )->expect('getDiff')->andReturn('foobar')->get();
        $this->exception =
            new ExpectationFailedException('', $failure);

        $result =
            $this->render(BaseTestRunner::STATUS_FAILURE, 10);
        $this->assertString($result)->contains("foobar");
    }

    public function testPHPUnitDiffsAreShownOnlyIfAvailable()
    {
        $this->exception =
            new ExpectationFailedException('', null);

        $result =
            $this->render(BaseTestRunner::STATUS_FAILURE, 10);
        $this->assertString($result)->contains("10.");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected integer, but got string for argument 1
     */
    public function testIssueNumberMustBeAnInteger()
    {
        $this->issue->render(
            BaseTestRunner::STATUS_FAILURE,
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

        $test = $this->mock(Test::class)->get();

        $this->assertString(
            $renderIssue->getHeading(
                BaseTestRunner::STATUS_FAILURE,
                1,
                $test
            )
        )->doesNotContain('::');
    }

    /**
     * @group #238
     */
    public function testWillRemoveCarriageReturns()
    {
        $result = $this->render(
            BaseTestRunner::STATUS_FAILURE,
            0,
            "foo\n\rbar"
        );
        $this->assertString($result)->doesNotContain("\r");
    }
}
