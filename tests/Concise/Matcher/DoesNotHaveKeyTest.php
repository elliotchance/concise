<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class DoesNotHaveKeyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotHaveKey();
    }

    public function testArrayHasIntegerKey()
    {
        $this->assertFailure('[123] does not have key 0');
    }

    public function testKeyDoesNotExist()
    {
        $this->assert('[123] does not have key 1');
    }

    public function testArrayHasStringKey()
    {
        $this->assertFailure(array("abc" => 123), does_not_have_key, "abc");
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
