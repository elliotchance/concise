<?php

namespace Concise\Module;

use DateTime;

/**
 * @group matcher
 */
class DateAndTimeModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new DateAndTimeModule();
    }

    public function dataProvider()
    {
        return array(
            'before' => array('2014-01-02', '2014-02-02', false),
            'after' => array('2014-03-02', '2014-02-02', true),
            'equal' => array('2014-02-02', '2014-02-02', false),
            'timezone before' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T15:52:01+10:00',
                true
            ),
            'timezone after' => array(
                '2005-08-15T15:52:01+10:00',
                '2005-08-15T15:52:01+00:00',
                false
            ),
            'timezone equal' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T05:52:01-10:00',
                false
            ),
            'invalid left' => array('foo', '2014-02-02', false),
            'invalid right' => array('2014-02-02', 'foo', false),
            'invalid both' => array('foo', 'bar', false),
            'datetime left' => array(
                new DateTime('2014-01-02'),
                '2014-02-02',
                false
            ),
            'datetime right' => array(
                '2014-01-02',
                new DateTime('2014-02-02'),
                false
            ),
            'datetime both' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-02-02'),
                false
            ),
            'datetime equal' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-01-02'),
                false
            ),
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
        if (!$shouldPass) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }
        $this->assertDate($left)->isAfter($right);
    }

    public function dataProvider1()
    {
        return array(
            'before' => array('2014-01-02', '2014-02-02', true),
            'after' => array('2014-03-02', '2014-02-02', false),
            'equal' => array('2014-02-02', '2014-02-02', false),
            'timezone before' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T15:52:01+10:00',
                false
            ),
            'timezone after' => array(
                '2005-08-15T15:52:01+10:00',
                '2005-08-15T15:52:01+00:00',
                true
            ),
            'timezone equal' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T05:52:01-10:00',
                false
            ),
            'invalid left' => array('foo', '2014-02-02', false),
            'invalid right' => array('2014-02-02', 'foo', false),
            'invalid both' => array('foo', 'bar', false),
            'datetime left' => array(
                new DateTime('2014-01-02'),
                '2014-02-02',
                true
            ),
            'datetime right' => array(
                '2014-01-02',
                new DateTime('2014-02-02'),
                true
            ),
            'datetime both' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-02-02'),
                true
            ),
            'datetime equal' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-01-02'),
                false
            ),
            'epoch left' => array(1413705413, '2014-12-19', true),
            'epoch right' => array('2014-01-02', 1413705413, true),
            'epoch both' => array(1413705403, 1413705413, true),
            'epoch equal' => array(1413705413, 1413705413, false),
        );
    }

    /**
     * @dataProvider dataProvider1
     */
    public function testDateIsBefore($left, $right, $shouldPass)
    {
        if (!$shouldPass) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }
        $this->assertDate($left)->isBefore($right);
    }
}
