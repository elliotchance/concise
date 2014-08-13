<?php

namespace Concise\Matcher;

class IsNullTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNull();
    }

    public function testIsNull()
    {
        $this->assert(null, is_null);
    }

    public function testIsNullFailure()
    {
        $this->assertFailure('123 is null');
    }
}
