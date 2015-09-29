<?php

namespace Concise\Console\TestRunner;

use Concise\Core\TestCase;

class DefaultTestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->assert(new DefaultTestRunner())
            ->isAnInstanceOf('PHPUnit_TextUI_TestRunner');
    }
}
