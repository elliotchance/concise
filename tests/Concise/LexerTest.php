<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function testLexerWillReturnTokensForString()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('a equals b');
		$this->assertEquals(array('a', 'equals', 'b'), $result['tokens']);
	}

	public function testLexerWillReturnSyntaxTokensForString()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('a equals b');
		$this->assertEquals('? equals ?', $result['syntax']);
	}
}
