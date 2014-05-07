<?php

namespace Concise;

class AttributeTest extends TestCase
{
	public function testAttributeNameIsSetInConstructor()
	{
		$attribute = new Attribute('abc');
		$this->assertEquals('abc', $attribute->getName());
	}

	// @test casting to string is the same as getName()
}
