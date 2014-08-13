<?php

namespace Concise\Matcher;

class IsAnObjectTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnObject();
    }

    public function testIsAnObject()
    {
        $this->assert(new \stdClass(), is_an_object);
    }

    public function testIsAnObjectFailure()
    {
        $this->assertFailure('123 is an object');
    }
}
