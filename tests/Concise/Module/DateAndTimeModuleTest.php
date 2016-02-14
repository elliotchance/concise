<?php

namespace Concise\Module;

use DateTime;

/**
 * This whole test suite will only work under PHP 5.4 and above becuase of the
 * way dates are formatted differently in PHP 5.3. It doesn't matter too much
 * that we skip these for PHP 5.3 becuase all the other versions of PHP will be
 * tested on Travis.
 * 
 * @group matcher
 * @requires PHP 5.4
 */
class DateAndTimeModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new DateAndTimeModule();
    }

    public function dateIsAfter()
    {
        return array(
            'before' => array(
                '2014-01-02',
                '2014-02-02',
                'date "2014-01-02 (2014-01-02T00:00:00+11:00)" is after "2014-02-02 (2014-02-02T00:00:00+11:00)"'
            ),
            'after' => array('2014-03-02', '2014-02-02'),
            'equal' => array(
                '2014-02-02',
                '2014-02-02',
                'date "2014-02-02 (2014-02-02T00:00:00+11:00)" is after "2014-02-02 (2014-02-02T00:00:00+11:00)"'
            ),
            'timezone before' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T15:52:01+10:00'
            ),
            'timezone after' => array(
                '2005-08-15T15:52:01+10:00',
                '2005-08-15T15:52:01+00:00',
                'date "2005-08-15T15:52:01+10:00 (2005-08-15T15:52:01+10:00)" is after "2005-08-15T15:52:01+00:00 (2005-08-16T01:52:01+10:00)"'
            ),
            'timezone equal' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T05:52:01-10:00',
                'date "2005-08-15T15:52:01+00:00 (2005-08-16T01:52:01+10:00)" is after "2005-08-15T05:52:01-10:00 (2005-08-16T01:52:01+10:00)"'
            ),
            'invalid left' => array(
                'foo',
                '2014-02-02',
                "Invalid date 'foo'"
            ),
            'invalid right' => array(
                '2014-02-02',
                'foo',
                "Invalid date 'foo'"
            ),
            'invalid both' => array(
                'foo',
                'bar',
                "Invalid date 'foo'"
            ),
            'datetime left' => array(
                new DateTime('2014-01-02'),
                '2014-02-02',
                <<<TXT
date DateTime:{
  "date":"2014-01-02 00:00:00.000000",
  "timezone_type":3,
  "timezone":"Australia/Sydney"
} is after "2014-02-02 (2014-02-02T00:00:00+11:00)"
TXT
            ),
            'datetime right' => array(
                '2014-01-02',
                new DateTime('2014-02-02'),
                'e'
            ),
            'datetime both' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-02-02'),
                'f'
            ),
            'datetime equal' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-01-02'),
                <<<TXT
date DateTime:{
  "date":"2014-01-02 00:00:00.000000",
  "timezone_type":3,
  "timezone":"Australia/Sydney"
} is after DateTime:{
  "date":"2014-01-02 00:00:00.000000",
  "timezone_type":3,
  "timezone":"Australia/Sydney"
}
TXT
            ),
            'epoch left' => array(
                1413705413,
                '2014-12-19',
                'date "1413705413 (2014-10-19T18:56:53+11:00)" is after "2014-12-19 (2014-12-19T00:00:00+11:00)"'
            ),
            'epoch right' => array('2014-01-02', 1413705413, 'i'),
            'epoch both' => array(
                1413705403,
                1413705413,
                'date "1413705403 (2014-10-19T18:56:43+11:00)" is after "1413705413 (2014-10-19T18:56:53+11:00)"'
            ),
            'epoch equal' => array(
                1413705413,
                1413705413,
                'date "1413705413 (2014-10-19T18:56:53+11:00)" is after "1413705413 (2014-10-19T18:56:53+11:00)"'
            ),
        );
    }

    /**
     * @dataProvider dateIsAfter
     */
    public function testDateIsAfter($left, $right, $error = null)
    {
        if ($error) {
            $this->expectFailure($error);
        }
        $this->assertDate($left)->isAfter($right);
    }

    public function dateIsBefore()
    {
        return array(
            'before' => array('2014-01-02', '2014-02-02'),
            'after' => array('2014-03-02', '2014-02-02', 'date "2014-03-02 (2014-03-02T00:00:00+11:00)" is before "2014-02-02 (2014-02-02T00:00:00+11:00)"'),
            'equal' => array('2014-02-02', '2014-02-02', 'date "2014-02-02 (2014-02-02T00:00:00+11:00)" is before "2014-02-02 (2014-02-02T00:00:00+11:00)"'),
            'timezone before' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T15:52:01+10:00',
                'date "2005-08-15T15:52:01+00:00 (2005-08-16T01:52:01+10:00)" is before "2005-08-15T15:52:01+10:00 (2005-08-15T15:52:01+10:00)"'
            ),
            'timezone after' => array(
                '2005-08-15T15:52:01+10:00',
                '2005-08-15T15:52:01+00:00'
            ),
            'timezone equal' => array(
                '2005-08-15T15:52:01+00:00',
                '2005-08-15T05:52:01-10:00',
                'date "2005-08-15T15:52:01+00:00 (2005-08-16T01:52:01+10:00)" is before "2005-08-15T05:52:01-10:00 (2005-08-16T01:52:01+10:00)"'
            ),
            'invalid left' => array('foo', '2014-02-02', "Invalid date 'foo'"),
            'invalid right' => array('2014-02-02', 'foo', "Invalid date 'foo'"),
            'invalid both' => array('foo', 'bar', "Invalid date 'foo'"),
            'datetime left' => array(
                new DateTime('2014-01-02'),
                '2014-02-02'
            ),
            'datetime right' => array(
                '2014-01-02',
                new DateTime('2014-02-02')
            ),
            'datetime both' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-02-02')
            ),
            'datetime equal' => array(
                new DateTime('2014-01-02'),
                new DateTime('2014-01-02'),
                <<<TXT
date DateTime:{
  "date":"2014-01-02 00:00:00.000000",
  "timezone_type":3,
  "timezone":"Australia/Sydney"
} is before DateTime:{
  "date":"2014-01-02 00:00:00.000000",
  "timezone_type":3,
  "timezone":"Australia/Sydney"
}
TXT
            ),
            'epoch left' => array(1413705413, '2014-12-19'),
            'epoch right' => array('2014-01-02', 1413705413),
            'epoch both' => array(1413705403, 1413705413),
            'epoch equal' => array(1413705413, 1413705413, 'date "1413705413 (2014-10-19T18:56:53+11:00)" is before "1413705413 (2014-10-19T18:56:53+11:00)"'),
        );
    }

    /**
     * @dataProvider dateIsBefore
     */
    public function testDateIsBefore($left, $right, $error = null)
    {
        if ($error) {
            $this->expectFailure($error);
        }
        $this->assertDate($left)->isBefore($right);
    }
}
