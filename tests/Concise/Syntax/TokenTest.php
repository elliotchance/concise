<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class TokenTest extends TestCase
{
	public function testTypeIsRequiredByConstructor()
	{
		$attribute = new Token(Lexer::TOKEN_STRING);
		$this->assertEquals(Lexer::TOKEN_STRING, $attribute->getType());
	}

	public function testDefaultValueIsNull()
	{
		$attribute = new Token(Lexer::TOKEN_STRING);
		$this->assertNull($attribute->getValue());
	}

	public function testValueCanBeProvidedThroughConstructor()
	{
		$attribute = new Token(Lexer::TOKEN_STRING, 'abc');
		$this->assertEquals('abc', $attribute->getValue());
	}
}
