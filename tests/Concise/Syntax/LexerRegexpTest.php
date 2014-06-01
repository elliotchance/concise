<?php

namespace Concise\Syntax;

use \Concise\Syntax\Attribute;

class LexerRegexpTest extends LexerTestCase
{
	protected function assertion()
	{
		return 'x equals /\\a/';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_ATTRIBUTE, 'x'),
			new Token(Lexer::TOKEN_KEYWORD, 'equals'),
			new Token(Lexer::TOKEN_REGEXP, '\\a'),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(new Attribute('x'), '\\a');
	}
}
