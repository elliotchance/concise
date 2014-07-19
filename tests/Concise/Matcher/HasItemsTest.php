<?php

namespace Concise\Matcher;

class HasItemsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new HasItems();
	}

	public function testZeroItemsWillAlwaysMatch()
	{
		$this->assert(array("foo" => 123), has_items, array());
	}

	public function testSingleItemIsInSet()
	{
		$this->assert(array("foo" => 123), has_items, array("foo" => 123));
	}

	public function testSingleItemIsNotInSet()
	{
		$this->assertFailure(array("foo" => 123), has_items, array("foo" => 124));
	}

	public function testAllItemsAreInSet()
	{
		$this->assert(array("foo" => 123, "bar" => "baz"), has_items, array("foo" => 123, "bar" => "baz"));
	}

	public function testAllItemsAreInSubset()
	{
		$this->assert(array("foo" => 123, "a" => "b", "bar" => "baz"), has_items, array("foo" => 123, "bar" => "baz"));
	}
}
