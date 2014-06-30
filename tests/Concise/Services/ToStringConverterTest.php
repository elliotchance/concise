<?php

namespace Concise\Services;

class ToStringConverterTest extends \Concise\TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->converter = new ToStringConverter();
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
		$this->assert($this->converter->convertToString(123), 'exactly equals "123"');
	}

	public function testWillReturnTheMethodsReturnValueIfItIsCallable()
	{
		$this->assert($this->converter->convertToString(function () {
			return 'abc';
		}), 'exactly equals "abc"');
	}

	public function testWillAlwaysReturnAStringEvenIfItHasToRecurse()
	{
		$this->assert($this->converter->convertToString(function () {
			return function() {
				return 123;
			};
		}), 'exactly equals "123"');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert NULL to string.
	 */
	public function testWillThrowExceptionIfANullValueIsUsed()
	{
		$this->converter->convertToString(null);
	}

	public function testWillReturnTheExceptionMessageIfTheCallableValueThrowsAnException()
	{
		$this->assert($this->converter->convertToString(function () {
			throw new \Exception('hi');
		}), 'exactly equals "hi"');
	}

	public function testWillRenderAnObjectAsAString()
	{
		$object = $this->getStub('\stdClass', array(
			'__toString' => 'xyz'
		));
		$this->assertSame($this->converter->convertToString($object), 'xyz');
	}

	public function testWillExpandScientificNotationToAbsoluteValue()
	{
		$this->assertSame($this->converter->convertToString(1.23e5), '123000');
	}

	public function testWillReturnAJsonStringForAnObjectIfIsCannotBeConvertedToAString()
	{
		$object = new \stdClass();
		$object->abc = 123;
		$this->assertSame($this->converter->convertToString($object), '{"abc":123}');
	}

	public function testWillReturnAJsonStringForAnArray()
	{
		$this->assertSame($this->converter->convertToString(array(1, 'abc')), '[1,"abc"]');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert resource to string.
	 */
	public function testWillThrowExceptionIfAResourceValueIsUsed()
	{
		$this->converter->convertToString(fopen('.', 'r'));
	}
}
