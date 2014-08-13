<?php

namespace Concise\Matcher;

class IsLessThanEqualTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsLessThanEqual();
    }

    public function testLessThan()
    {
        $this->assert(100, is_less_than_or_equal_to, 200);
    }

    public function testLessThanOrEqual()
    {
        $this->assert(200, is_less_than_or_equal_to, 200);
    }

    public function testGreaterThan()
    {
        $this->assertFailure(300, is_less_than_or_equal_to, 200);
    }
}
