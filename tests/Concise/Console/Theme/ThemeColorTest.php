<?php

namespace Concise\Console\Theme;

use Concise\Core\TestCase;

class ThemeColorTest extends TestCase
{
    public function testRed()
    {
        $this->assert(ThemeColor::RED)->exactlyEquals('red');
    }

    public function testNone()
    {
        $this->assert(ThemeColor::NONE)->exactlyEquals('');
    }
}
