<?php

namespace Concise\Syntax;

class LexerRegexpTest extends LexerTestCase
{
	protected function assertion()
	{
		return 'x equals /\\a/';
	}

	protected function expectedTokens()
	{
		return array(
			new Token\Attribute('x'),
			new Token\Keyword('equals'),
			new Token\Regexp('\\a'),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(new Token\Attribute('x'), new Token\Regexp('\\a'));
	}
}
