<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function testReadKeywordToken()
	{
		$this->assertEquals(Lexer::TOKEN_KEYWORD, Lexer::getTokenType('equals'));
	}

	public function testReadAttributeToken()
	{
		$this->assertEquals(Lexer::TOKEN_ATTRIBUTE, Lexer::getTokenType('z'));
	}
}
