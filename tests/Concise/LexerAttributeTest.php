<?php

namespace Concise;

class LexerAttributeTest extends LexerTestCase
{
	protected function assertion()
	{
		return 'x equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_ATTRIBUTE, 'x'),
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
		return array(new Attribute('x'), new Attribute('b'));
	}
}
