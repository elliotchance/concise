<?php

namespace Concise\Matcher;

class DoesNotHaveItemTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotHaveItem();
    }

    public function testKeyValuePairExists()
    {
        $this->assertFailure(array("foo" => 123), does_not_have_key, "foo", with_value, 123);
    }

    public function testAlternativeSyntaxForItemExists()
    {
        $this->assertFailure(array("foo" => 123), does_not_have_item, array("foo" => 123));
    }

    public function testItemDoesNotExist()
    {
        $this->assert(array("foo" => 123), does_not_have_item, array("foo" => 124));
    }

    public function testItemExistsInMultipleItems()
    {
        $this->assertFailure(array("foo" => 123, "bar" => "baz"), does_not_have_key, "foo", with_value, 123);
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
