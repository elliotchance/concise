<?php

namespace Concise\Syntax;

class LexerIntegerTest extends LexerTestCase
{
	protected function assertion()
	{
		return '123 equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token\Value(123),
			new Token\Keyword('equals'),
			new Token\Attribute('b'),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(123, new Token\Attribute('b'));
	}
}
