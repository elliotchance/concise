<?php

namespace Concise\Matcher;

class HasKeysTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasKeys();
    }

    public function testArrayHasOneKey()
    {
        $this->assert('[123] has keys [0]');
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assertFailure('[123] has keys [0,1]');
    }

    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->assert(array("a" => 123, "b" => 456), has_keys, array("b", "a"));
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->assert(array("a" => 123, "b" => 456), has_keys, array("b"));
    }
}
