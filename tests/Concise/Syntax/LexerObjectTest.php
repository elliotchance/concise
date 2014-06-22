<?php

namespace Concise\Syntax;

class LexerObjectTest extends LexerTestCase
{
	protected function assertion()
	{
		return '{} equals {"a":123}';
	}

	protected function getSimpleObject()
	{
		$obj = new \stdClass();
		$obj->a = 123;
		return $obj;
	}

	protected function expectedTokens()
	{
		return array(
			new Token\Value(new \stdClass()),
			new Token\Keyword('equals'),
			new Token\Value($this->getSimpleObject()),
		);
	}

	protected function expectedSyntax()
	{
		return '? equals ?';
	}

	protected function expectedArguments()
	{
		return array(new \stdClass(), $this->getSimpleObject());
	}
}
