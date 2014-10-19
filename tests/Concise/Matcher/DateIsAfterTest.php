<?php

namespace Concise\Matcher;

use DateTime;

class DateIsAfterTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DateIsAfter();
    }

    public function dataProvider()
    {
        return array(
            'before' => array('2014-01-02', '2014-02-02', false),
            'after' => array('2014-03-02', '2014-02-02', true),
            'equal' => array('2014-02-02', '2014-02-02', false),
            'timezone before' => array('2005-08-15T15:52:01+00:00', '2005-08-15T15:52:01+10:00', true),
            'timezone after' => array('2005-08-15T15:52:01+10:00', '2005-08-15T15:52:01+00:00', false),
            'timezone equal' => array('2005-08-15T15:52:01+00:00', '2005-08-15T05:52:01-10:00', false),
            'invalid left' => array('foo', '2014-02-02', false),
            'invalid right' => array('2014-02-02', 'foo', false),
            'invalid both' => array('foo', 'bar', false),
            'datetime left' => array(new DateTime('2014-01-02'), '2014-02-02', false),
            'datetime right' => array('2014-01-02', new DateTime('2014-02-02'), false),
            'datetime both' => array(new DateTime('2014-01-02'), new DateTime('2014-02-02'), false),
            'datetime equal' => array(new DateTime('2014-01-02'), new DateTime('2014-01-02'), false),
            'epoch left' => array(1413705413, '2014-12-19', false),
            'epoch right' => array('2014-01-02', 1413705413, false),
            'epoch both' => array(1413705403, 1413705413, false),
            'epoch equal' => array(1413705413, 1413705413, false),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDateIsAfter($left, $right, $shouldPass)
    {
        if ($shouldPass) {
            $this->assert(date, $left, is_after, $right);
        } else {
            $this->assertFailure(date, $left, is_after, $right);
        }
    }
}
