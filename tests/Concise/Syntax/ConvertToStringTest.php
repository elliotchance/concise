<?php

namespace Concise\Syntax;

class ConvertToStringTest extends \Concise\TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->converter = new ConvertToString();
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert boolean to string.
	 */
	public function testWillThrowExceptionIfABooleanTrueValueIsUsed()
	{
		$this->converter->convertToString(true);
	}

	public function testWillReturnTheExactStringUsed()
	{
		$this->assertSame($this->converter->convertToString('hello'), 'hello');
	}
}
