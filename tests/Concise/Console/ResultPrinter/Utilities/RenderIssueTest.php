<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class RenderIssueTest extends TestCase
{
    public function testStartsWithTheIssueNumber()
    {
        $issue = new RenderIssue();
        $this->assert($issue->render(123), starts_with, '123. ');
    }
}
