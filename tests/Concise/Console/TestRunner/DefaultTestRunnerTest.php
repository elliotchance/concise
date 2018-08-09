<?php

namespace Concise\Console\TestRunner;

use Concise\Core\TestCase;
use PHPUnit\TextUI\TestRunner;

class DefaultTestRunnerTest extends TestCase
{
    public function testTestRunnerExtendsPHPUnit()
    {
        $this->assert(new DefaultTestRunner())
            ->isAnInstanceOf(TestRunner::class);
    }
}
