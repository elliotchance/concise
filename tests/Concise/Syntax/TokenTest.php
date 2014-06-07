<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class TokenTest extends TestCase
{
	public function testDefaultValueIsNull()
	{
		$attribute = new Token();
		$this->assertNull($attribute->getValue());
	}

	public function testValueCanBeProvidedThroughConstructor()
	{
		$attribute = new Token\Value('abc');
		$this->assertEquals('abc', $attribute->getValue());
	}

	public function testRenderAsStringUsesValue()
	{
		$attribute = new Token\Value('abc');
		$this->assertEquals('abc', (string) $attribute);
	}
}
