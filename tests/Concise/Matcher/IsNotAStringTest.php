<?php

namespace Concise\Matcher;

class IsNotAStringTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotAString();
    }

    public function testIsNotAString()
    {
        $this->assert('123 is not a string');
    }

    public function testIsNotAStringFailure()
    {
        $this->assertFailure('"123" is not a string');
    }

    public function tags()
    {
        return array(Tag::STRINGS, Tag::TYPES);
    }
}
