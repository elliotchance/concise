<?php

namespace Concise;

class LexerFloatTest extends LexerTestCase
{
	protected function assertion()
	{
		return '1.23 equals .45';
	}

	protected function expectedTokens()
	{
		return array(1.23, 'equals', 0.45);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(1.23, 0.45);
	}
}
