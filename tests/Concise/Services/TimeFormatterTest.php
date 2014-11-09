<?php

namespace Concise\Services;

use Concise\TestCase;

class TimeFormatterTest extends TestCase
{
    /**
     * @var TimeFormatter
     */
    protected $formatter;

    public function setUp()
    {
        parent::setUp();
        $this->formatter = new TimeFormatter();
    }

    public function testFormattingZeroSeconds()
    {
        $this->assert($this->formatter->format(0), equals, '0 seconds');
    }

    public function testFormattingTwoSeconds()
    {
        $this->assert($this->formatter->format(2), equals, '2 seconds');
    }

    public function testFormattingOneSecond()
    {
        $this->assert($this->formatter->format(1), equals, '1 second');
    }

    public function testFormattingOneMinute()
    {
        $this->assert($this->formatter->format(60), equals, '1 minute');
    }

    public function testFormattingTwoMinutes()
    {
        $this->assert($this->formatter->format(120), equals, '2 minutes');
    }

    public function testFormattingEightySeconds()
    {
        $this->assert($this->formatter->format(80), equals, '1 minute 20 seconds');
    }
}
