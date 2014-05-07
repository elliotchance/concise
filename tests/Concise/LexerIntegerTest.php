<?php

namespace Concise;

class LexerIntegerTest extends LexerTestCase
{
	protected function assertion()
	{
		return '123 equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_INTEGER, 123),
			new Token(Lexer::TOKEN_KEYWORD, 'equals'),
			new Token(Lexer::TOKEN_ATTRIBUTE, 'b'),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(123, new Attribute('b'));
	}
}
