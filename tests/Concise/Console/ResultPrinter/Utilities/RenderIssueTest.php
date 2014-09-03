<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;
use Exception;
use PHPUnit_Runner_BaseTestRunner;

class RenderIssueTest extends TestCase
{
    protected $issue;

    protected $test;

    protected $exception;

    public function setUp()
    {
        parent::setUp();
        $this->issue = new RenderIssue();
        $this->test = $this->mock('PHPUnit_Framework_TestCase')
                           ->stub(array('getName' => 'foo'))
                           ->done();
        $this->exception = new Exception('foo bar');
    }

    public function testStartsWithTheIssueNumber()
    {
        $this->assert($this->issue->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 123, $this->test, $this->exception), starts_with, '123. ');
    }

    public function testIncludesTestClass()
    {
        $class = get_class($this->test);
        $this->assert($this->issue->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 123, $this->test, $this->exception), contains_string, $class);
    }

    public function testIncludesTheMethodName()
    {
        $this->assert($this->issue->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 123, $this->test, $this->exception), contains_string, 'foo');
    }

    public function testIncludesExceptionMessage()
    {
        $this->assert($this->issue->render(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE, 123, $this->test, $this->exception), contains_string, $this->exception->getMessage());
    }

    protected function getTraceSimplifier()
    {
        return $this->mock('Concise\Console\ResultPrinter\Utilities\TraceSimplifier')
                    ->expect('render')->with($this->exception->getTrace())->andReturn("foo\nbar")
                    ->done();
    }

    protected function render($status = PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE)
    {
        $simplifier = $this->getTraceSimplifier();
        $issue = new RenderIssue($simplifier);

        return $issue->render($status, 0, $this->test, $this->exception);
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

    public function testClearFormattingAfterStackTraceToPreventUnwantedTextFromBeingColored()
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
}
