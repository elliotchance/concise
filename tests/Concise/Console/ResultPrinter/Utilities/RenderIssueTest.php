<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class RenderIssueTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->issue = new RenderIssue();
        $this->test = $this->mock('PHPUnit_Framework_TestCase')
                           ->stub(['getName' => 'foo'])
                           ->done();
    }

    public function testStartsWithTheIssueNumber()
    {
        $this->assert($this->issue->render(123, $this->test), starts_with, '123. ');
    }

    public function testIncludesTestClass()
    {
        $class = get_class($this->test);
        $this->assert($this->issue->render(123, $this->test), contains_string, $class);
    }

    public function testIncludesTheMethodName()
    {
        $this->assert($this->issue->render(123, $this->test), contains_string, 'foo');
    }
}
