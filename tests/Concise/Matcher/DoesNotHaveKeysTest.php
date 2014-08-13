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
        $this->assertFailure('["a":123,"b":456] does not have keys ["b","a"]');
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->assertFailure('["a":123,"b":456] does not have keys ["b"]');
    }
}
