<?php

namespace Concise;

class LexerFloatTest extends LexerTestCase
{
	protected function assertion()
	{
		return '1.23 equals .45';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_FLOAT, 1.23),
			new Token(Lexer::TOKEN_KEYWORD, 'equals'),
			new Token(Lexer::TOKEN_FLOAT, 0.45),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(1.23, 0.45);
	}
}
