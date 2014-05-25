<?php

namespace Concise\Syntax;

use \Concise\Syntax\Attribute;

class LexerCodeTest extends LexerTestCase
{
	protected function assertion()
	{
		return '`1 + 2` equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_CODE, '1 + 2'),
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
		return array('1 + 2', new Attribute('b'));
	}
}
