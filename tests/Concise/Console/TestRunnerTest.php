<?php

namespace Concise\Console;

use \Concise\TestCase;

class TestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->assert(new TestRunner(), instance_of, 'PHPUnit_TextUI_TestRunner');
    }
}
