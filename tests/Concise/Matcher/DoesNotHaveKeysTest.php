<?php

namespace Concise\Matcher;

class DoesNotHaveKeysTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotHaveKeys();
    }

    public function testArrayHasOneKey()
    {
        $this->assertFailure('[123] does not have keys [0]');
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assert('[123] does not have keys [0,1]');
    }

    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->assertFailure(array("a" => 123, "b" => 456), does_not_have_keys, array("b", "a"));
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->assertFailure(array("a" => 123, "b" => 456), does_not_have_keys, array("b"));
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
