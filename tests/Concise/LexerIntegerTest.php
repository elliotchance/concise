<?php

namespace Concise;

class LexerIntegerTest extends LexerTestCase
{
	protected function assertion()
	{
		return '123 equals b';
	}

	protected function expectedTokens()
	{
		return array(123, 'equals', 'b');
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(123, new Attribute());
	}
}
