<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsAStringTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAString();
    }

    public function testIsAString()
    {
        $this->assert('"123" is a string');
    }

    public function testIsAStringFailure()
    {
        $this->assertFailure('123 is a string');
    }

    public function testClassNameIsAString()
    {
        $this->assert('\My\Class is a string');
    }

    public function tags()
    {
        return array(Tag::STRINGS, Tag::TYPES);
    }
}
