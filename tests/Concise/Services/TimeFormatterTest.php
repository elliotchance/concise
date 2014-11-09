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
}
