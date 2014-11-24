<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
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

    public function tags()
    {
        return array(Tag::OBJECTS, Tag::TYPES);
    }
}
