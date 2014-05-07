<?php

namespace Concise;

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
}
