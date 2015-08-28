<?php

namespace Concise\Console\TestRunner;

use Concise\TestCase;

class DefaultTestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->aassert(new DefaultTestRunner())
            ->isInstanceOf('PHPUnit_TextUI_TestRunner');
    }
}
