<?php

namespace Concise\Console\Theme;

use Concise\Core\TestCase;

/**
 * @group #339
 */
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

    public function testGreen()
    {
        $this->assert(ThemeColor::GREEN)->exactlyEquals('green');
    }

    public function testYellow()
    {
        $this->assert(ThemeColor::YELLOW)->exactlyEquals('yellow');
    }

    public function testBlue()
    {
        $this->assert(ThemeColor::BLUE)->exactlyEquals('blue');
    }

    public function testMagenta()
    {
        $this->assert(ThemeColor::MAGENTA)->exactlyEquals('magenta');
    }
}
