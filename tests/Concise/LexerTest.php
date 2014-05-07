<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function testLexerWillReturnTokensForString()
	{
		$lexer = new Lexer();
		$tokens = $lexer->parse('some tokens');
		$this->assertEquals(array('some', 'tokens'), $tokens);
	}
}
