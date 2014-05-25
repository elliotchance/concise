<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class AttributeTest extends TestCase
{
	public function _test_attribute()
	{
		$this->attribute = new Attribute('abc');
		return array(
			'attribute name is set in constructor' => '`$self->attribute->getName()` equals "abc"',
			'casting to string is the same as get name' => '`(string) $self->attribute` equals "abc"',
		);
	}
}
