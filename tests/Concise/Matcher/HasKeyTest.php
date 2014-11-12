<?php

namespace Concise\Matcher;

class HasKeyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasKey();
    }

    public function testArrayHasIntegerKey()
    {
        $this->assert('[123] has key 0');
    }

    public function testKeyDoesNotExist()
    {
        $this->assertFailure('[123] has key 1');
    }

    public function testArrayHasStringKey()
    {
        $this->assert(array("abc" => 123), has_key, "abc");
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }

    public function testThisMatcherCanBeNested()
    {
        $this->assert($this->matcher, is_instance_of, '\Concise\Matcher\AbstractNestedMatcher');
    }

    /**
     * @expectedException \Concise\Matcher\DidNotMatchException
     */
    public function testFailureThrowsException()
    {
        $this->matcher->match(null, array(array(), 'foo'));
    }

    public function testNestedException()
    {
        $this->assert($this->assert(array("abc" => 123), has_key, "abc"), equals, 123);
    }
}
