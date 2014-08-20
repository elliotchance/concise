<?php

namespace Concise\Matcher;

class IsGreaterThanEqualTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsGreaterThanEqual();
    }

    public function testLessThan()
    {
        $this->assertFailure(100, is_greater_than_or_equal_to, 200);
    }

    public function testGreaterThanOrEqual()
    {
        $this->assert(200, is_greater_than_or_equal_to, 200);
    }

    public function testGreaterThan()
    {
        $this->assert(300, is_greater_than_or_equal_to, 200);
    }
}
