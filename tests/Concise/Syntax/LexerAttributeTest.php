<?php

namespace Concise\Syntax;

class LexerAttributeTest extends LexerTestCase
{
	protected function assertion()
	{
		return 'x equals b';
	}

	protected function expectedTokens()
	{
		return array(
			new Token\Attribute('x'),
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
		return array(new Token\Attribute('x'), new Token\Attribute('b'));
	}
}
