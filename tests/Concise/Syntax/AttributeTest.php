<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class AttributeTest extends TestCase
{
	public function testAttributeNameIsSetInConstructor()
	{
		$attribute = new Attribute('abc');
		$this->assertEquals('abc', $attribute->getName());
	}

	public function testCastingToStringIsTheSameAsGetName()
	{
		$attribute = new Attribute('abc');
		$this->assertEquals('abc', (string) $attribute);
	}
}
