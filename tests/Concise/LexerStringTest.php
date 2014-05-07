<?php

namespace Concise;

class LexerStringTest extends LexerTestCase
{
	protected function assertion()
	{
		return '"abc" equals b';
	}

	protected function expectedTokens()
	{
		return array('"abc"', 'equals', 'b');
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
