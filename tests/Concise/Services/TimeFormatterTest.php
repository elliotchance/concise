<?php

namespace Concise\Services;

use Concise\TestCase;

class TimeFormatterTest extends TestCase
{
    public function testFormattingZeroSeconds()
    {
        $formatter = new TimeFormatter();
        $this->assert($formatter->format(0), equals, '0 seconds');
    }

    public function testFormattingTwoSeconds()
    {
        $formatter = new TimeFormatter();
        $this->assert($formatter->format(2), equals, '2 seconds');
    }
}
