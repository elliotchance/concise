<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function testReadKeywordToken()
	{
		$this->assertEquals(Lexer::TOKEN_KEYWORD, Lexer::getTokenType('equals'));
	}
}
