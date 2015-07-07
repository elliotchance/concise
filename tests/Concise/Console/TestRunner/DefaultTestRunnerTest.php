<?php

namespace Concise\Console\TestRunner;

use Concise\TestCase;

class DefaultTestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->assert(
            new DefaultTestRunner(),
            instance_of,
            'PHPUnit_TextUI_TestRunner'
        );
    }
}
