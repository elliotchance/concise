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
}
