<?php

namespace Concise\Syntax;

use \Concise\Syntax\Attribute;

class LexerArrayTest extends LexerTestCase
{
	protected function assertion()
	{
		return '[] equals [123,"abc"]';
	}

	protected function expectedTokens()
	{
		return array(
			new Token(Lexer::TOKEN_ARRAY, array()),
			new Token(Lexer::TOKEN_KEYWORD, 'equals'),
			new Token(Lexer::TOKEN_ARRAY, array(123, "abc")),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(array(), array(123, "abc"));
	}
}
