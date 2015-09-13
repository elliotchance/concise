<?php

namespace Concise\Console\TestRunner;

use Concise\Core\TestCase;

class DefaultTestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->assert(new DefaultTestRunner())
            ->isInstanceOf('PHPUnit_TextUI_TestRunner');
    }
}
