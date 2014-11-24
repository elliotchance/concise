<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class StringDoesNotEndWithTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringDoesNotEndWith();
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->assert('"abc" does not end with "abcd"');
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->assert('"abc" does not end with "a"');
    }

    public function testStringDoesNotEndWithFailure()
    {
        $this->assertFailure('"abc" does not end with "abc"');
    }

    public function tags()
    {
        return array(Tag::STRINGS);
    }
}
