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

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert boolean to string.
	 */
	public function testWillThrowExceptionIfABooleanFalseValueIsUsed()
	{
		$this->converter->convertToString(false);
	}

	public function testWillConvertANumberToAString()
	{
		$this->assertSame($this->converter->convertToString(123), '123');
	}

	public function testWillReturnTheMethodsReturnValueIfItIsCallable()
	{
		$this->assertSame($this->converter->convertToString(function () {
			return 'abc';
		}), 'abc');
	}

	public function testWillAlwaysReturnAStringEvenIfItHasToRecurse()
	{
		$this->assertSame($this->converter->convertToString(function () {
			return function() {
				return 123;
			};
		}), '123');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert NULL to string.
	 */
	public function testWillThrowExceptionIfANullValueIsUsed()
	{
		$this->converter->convertToString(null);
	}
}
