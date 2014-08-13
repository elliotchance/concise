<?php

namespace Concise\Matcher;

class HasItemTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasItem();
    }

    public function testKeyValuePairExists()
    {
        $this->assert(array("foo" => 123), has_key, "foo", with_value, 123);
    }

    public function testAlternativeSyntaxForItemExists()
    {
        $this->assert(array("foo" => 123), has_item, array("foo" => 123));
    }

    public function testItemDoesNotExist()
    {
        $this->assertFailure(array("foo" => 123), has_item, array("foo" => 124));
    }

    public function testItemExistsInMultipleItems()
    {
        $this->assert(array("foo" => 123, "bar" => "baz"), has_key, "foo", with_value, 123);
    }
}
