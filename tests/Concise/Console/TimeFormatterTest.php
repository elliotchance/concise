<?php

namespace Concise\Console;

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

    public function data()
    {
        return array(
            array(0, '0 seconds', '0 sec'),
            array(2, '2 seconds', '2 sec'),
            array(1, '1 second', '1 sec'),
            array(60, '1 minute', '1 min'),
            array(120, '2 minutes', '2 min'),
            array(80, '1 minute 20 seconds', '1 min 20 sec'),
            array(3600, '1 hour', '1 hr'),
            array(7200, '2 hours', '2 hr'),
        );
    }

    /**
     * @group #239
     * @dataProvider data
     */
    public function testFormattingLong($seconds, $expected)
    {
        $this->assert($this->formatter->format($seconds, false))
            ->equals($expected);
    }

    /**
     * @group #239
     * @dataProvider data
     */
    public function testFormattingShort($seconds, $_, $expected)
    {
        $this->assert($this->formatter->format($seconds, true))
            ->equals($expected);
    }
}
