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
		$this->assert($this->converter->convertToString('hello'), equals, 'hello');
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
		$this->assert($this->converter->convertToString(123), exactly_equals, '123');
	}

	public function testWillReturnTheMethodsReturnValueIfItIsCallable()
	{
		$this->assert($this->converter->convertToString(function () {
			return 'abc';
		}), exactly_equals, 'abc');
	}

	public function testWillAlwaysReturnAStringEvenIfItHasToRecurse()
	{
		$this->assert($this->converter->convertToString(function () {
			return function() {
				return 123;
			};
		}), exactly_equals, '123');
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
		}), exactly_equals, "hi");
	}

	public function testWillRenderAnObjectAsAString()
	{
		$object = $this->mock()->stub(array('__toString' => 'xyz'))->done();
		$this->assert($this->converter->convertToString($object), equals, 'xyz');
	}

	public function testWillExpandScientificNotationToAbsoluteValue()
	{
		$this->assert($this->converter->convertToString(1.23e5), exactly_equals, '123000');
	}

	public function testWillReturnAJsonStringForAnObjectIfIsCannotBeConvertedToAString()
	{
		$object = new \stdClass();
		$object->abc = 123;
		$this->assert($this->converter->convertToString($object), equals, '{"abc":123}');
	}

	public function testWillReturnAJsonStringForAnArray()
	{
		$this->assert($this->converter->convertToString(array(1, 'abc')), equals, '[1,"abc"]');
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
