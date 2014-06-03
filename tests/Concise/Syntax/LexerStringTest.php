<?php

namespace Concise\Syntax;

class LexerStringTest extends LexerTestCase
{
	protected function assertion()
	{
		return '"abc" equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token\Value('abc'),
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
		return array('abc', new Token\Attribute('b'));
	}
}
