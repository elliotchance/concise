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
        $this->assert('["a":123,"b":456] has keys ["b","a"]');
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->assert('["a":123,"b":456] has keys ["b"]');
    }
}
