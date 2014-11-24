<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsNotAnArrayTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotAnArray();
    }

    public function testIsNotAnArray()
    {
        $this->assert('123 is not an array');
    }

    public function testIsNotAnArrayFailure()
    {
        $this->assertFailure('[] is not an array');
    }

    public function tags()
    {
        return array(Tag::ARRAYS, Tag::TYPES);
    }
}
