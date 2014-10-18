<?php

namespace Concise\Matcher;

class DateIsBeforeTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DateIsBefore();
    }

    public function testDateIsBeforeAnotherDate()
    {
        $this->assert(date, '2014-01-02', is_before, '2014-02-02');
    }
}
