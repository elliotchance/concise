<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class TokenTest extends TestCase
{
	public function testDefaultValueIsNull()
	{
		$attribute = new Token();
		$this->assert($attribute->getValue(), is_null);
	}

	public function testValueCanBeProvidedThroughConstructor()
	{
		$attribute = new Token\Value('abc');
		$this->assert($attribute->getValue(), equals, 'abc');
	}

	public function testRenderAsStringUsesValue()
	{
		$attribute = new Token\Value('abc');
		$this->assert((string) $attribute, equals, 'abc');
	}
}
