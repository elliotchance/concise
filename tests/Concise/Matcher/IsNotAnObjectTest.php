<?php

namespace Concise\Matcher;

class IsNotAnObjectTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnObject();
    }

    public function testIsNotAnObject()
    {
        $this->assert('123 is not an object');
    }

    public function testClassNameIsNotAnObject()
    {
        $this->assert('\My\Class is not an object');
    }

    public function testIsNotAnObjectFailure()
    {
        $this->assertFailure(new \stdClass(), is_not_an_object);
    }
}
