<?php

namespace Concise\Modules\Basic;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class EqualsTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new Equals();
    }

    public function comparisons()
    {
        return array(
            array('123 equals 123'),
            array('123 equals 123.0'),
            array('123 equals "123"'),
        );
    }

    /**
     * @dataProvider comparisons
     */
    public function testEquals($assertion)
    {
        $this->assert($assertion);
    }

    public function testEqualsFailure()
    {
        $this->assertFailure("123 equals 124");
    }
}
