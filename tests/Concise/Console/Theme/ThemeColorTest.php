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
        $this->assert(ThemeColor::RED)->exactlyEquals(1);
    }

    public function testNone()
    {
        $this->assert(ThemeColor::NONE)->exactlyEquals(0);
    }

    public function testGreen()
    {
        $this->assert(ThemeColor::GREEN)->exactlyEquals(2);
    }

    public function testYellow()
    {
        $this->assert(ThemeColor::YELLOW)->exactlyEquals(3);
    }

    public function testBlue()
    {
        $this->assert(ThemeColor::BLUE)->exactlyEquals(4);
    }

    public function testMagenta()
    {
        $this->assert(ThemeColor::MAGENTA)->exactlyEquals(5);
    }

    public function testCyan()
    {
        $this->assert(ThemeColor::CYAN)->exactlyEquals(6);
    }

    public function testGray()
    {
        $this->assert(ThemeColor::GRAY)->exactlyEquals(7);
    }
}
