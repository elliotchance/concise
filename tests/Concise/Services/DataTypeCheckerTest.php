<?php

namespace Concise\Services;

use \Concise\Syntax\Token\Attribute;
use \Concise\Syntax\Token\Regexp;

class DataTypeCheckerTest extends \Concise\TestCase
{
	/** @var DataTypeChecker */
	protected $dataTypeChecker;

	public function setUp()
	{
		parent::setUp();
		$this->dataTypeChecker = new DataTypeChecker();
	}

	public function testBlankAcceptsAnything()
	{
		$this->assertSame(123, $this->dataTypeChecker->check(array(), 123));
	}

	/**
	 * @expectedException \Exception
	 */
	public function testSendingValueOfDifferentExpectedTypeThrowsException()
	{
		$this->dataTypeChecker->check(array("int"), 1.23);
	}

	public function dataTypes()
	{
		return array(
			array(array("int"), 123),
			array(array("integer"), 123),
			array(array("float"), 1.23),
			array(array("double"), 1.23),
			array(array("string"), 'abc'),
			array(array("array"), array()),
			array(array("resource"), fopen('.', 'r')),
			array(array("object"), new \stdClass()),
			array(array("callable"), function() {}),
			array(array("int", "float"), 1.23),
			array(array("regex"), new Regexp('abc')),
			array(array("class"), 'Concise\Syntax\Token\Regexp'),
		);
	}

	/**
	 * @dataProvider dataTypes
	 */
	public function testDataTypes(array $types, $value)
	{
		$this->assertSame($value, $this->dataTypeChecker->check($types, $value));
	}

	/**
	 * @expectedException \Exception
	 */
	public function testSendingValueNotListedInExpectedTypesThrowsException()
	{
		$this->dataTypeChecker->check(array("int", "string"), 1.23);
	}

	/**
	 * @expectedException \Exception
	 */
	public function testExcludeModeWillNotAllowType()
	{
		$this->dataTypeChecker->setExcludeMode();
		$this->dataTypeChecker->check(array("int"), 123);
	}

	public function testAttributesAreEvaluatedFromContext()
	{
		$context = array(
			'foo' => 'bar',
		);
		$this->dataTypeChecker->setContext($context);
		$this->assertSame('bar', $this->dataTypeChecker->check(array('string'), new Attribute('foo')));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Attribute 'foo' does not exist.
	 */
	public function testWillThrowExceptionIfAttributeDoesNotExist()
	{
		$this->dataTypeChecker->check(array('string'), new Attribute('foo'));
	}

	public function testExcludeWithEmptyArrayAllowsAnything()
	{
		$this->dataTypeChecker->setExcludeMode();
		$this->assertSame(123, $this->dataTypeChecker->check(array(), 123));
	}

	public function testWillTrimBackslashOffClass()
	{
		$this->assertSame('My\Class', $this->dataTypeChecker->check(array('class'), '\My\Class'));
	}

	public function testWillNotTrimBackslashOffClassIfNotValidatingAgainstClass()
	{
		$this->assertSame('\My\Class', $this->dataTypeChecker->check(array('string'), '\My\Class'));
	}

	public function testWillNotTrimBackslashOffClassIfAnyValueCanBeAccepted()
	{
		$this->assertSame('\My\Class', $this->dataTypeChecker->check(array(), '\My\Class'));
	}

	public function testWillTrimBackslashOffClassWhenInAttribute()
	{
		$context = array(
			'foo' => '\Bar',
		);
		$this->dataTypeChecker->setContext($context);
		$this->assertSame('Bar', $this->dataTypeChecker->check(array('class'), new Attribute('foo')));
	}
}
