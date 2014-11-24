<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsLessThanTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsLessThan();
    }

    public function testLessThan()
    {
        $this->assert(100, is_less_than, 200);
    }

    public function testLessThanOrEqual()
    {
        $this->assertFailure(200, is_less_than, 200);
    }

    public function testGreaterThan()
    {
        $this->assertFailure(300, is_less_than, 200);
    }

    public function tags()
    {
        return array(Tag::NUMBERS);
    }
}
