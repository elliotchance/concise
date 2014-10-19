<?php

namespace Concise\Matcher;

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
