<?php

namespace Concise\Matcher;

use DateTime;

class DateIsBeforeTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DateIsBefore();
    }

    public function dataProvider()
    {
        return array(
            'before' => array('2014-01-02', '2014-02-02', true),
            'after' => array('2014-03-02', '2014-02-02', false),
            'equal' => array('2014-02-02', '2014-02-02', false),
            'timezone before' => array('2005-08-15T15:52:01+00:00', '2005-08-15T15:52:01+10:00', false),
            'timezone after' => array('2005-08-15T15:52:01+10:00', '2005-08-15T15:52:01+00:00', true),
            'timezone equal' => array('2005-08-15T15:52:01+00:00', '2005-08-15T05:52:01-10:00', false),
            'invalid left' => array('foo', '2014-02-02', false),
            'invalid right' => array('2014-02-02', 'foo', false),
            'invalid both' => array('foo', 'bar', false),
            'datetime left' => array(new DateTime('2014-01-02'), '2014-02-02', true),
            'datetime right' => array('2014-01-02', new DateTime('2014-02-02'), true),
            'datetime both' => array(new DateTime('2014-01-02'), new DateTime('2014-02-02'), true),
            'epoch left' => array(1413705413, '2014-12-19', true),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDateIsBefore($left, $right, $shouldPass)
    {
        if ($shouldPass) {
            $this->assert(date, $left, is_before, $right);
        } else {
            $this->assertFailure(date, $left, is_before, $right);
        }
    }
}
