<?php

namespace Concise\Syntax;

use \Concise\Syntax\Attribute;

class LexerStringTest extends LexerTestCase
{
	protected function assertion()
	{
		return '"abc" equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_STRING, 'abc'),
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
		return array('abc', new Attribute('b'));
	}
}
