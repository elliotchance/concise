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
}
