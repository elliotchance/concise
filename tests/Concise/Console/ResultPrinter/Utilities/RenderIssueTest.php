<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class RenderIssueTest extends TestCase
{
    public function testStartsWithTheIssueNumber()
    {
        $issue = new RenderIssue();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $this->assert($issue->render(123, $test), starts_with, '123. ');
    }

    public function testIncludesTestClass()
    {
        $issue = new RenderIssue();
        $test = $this->mock('PHPUnit_Framework_Test')->done();
        $class = get_class($test);
        $this->assert($issue->render(123, $test), contains_string, $class);
    }
}
