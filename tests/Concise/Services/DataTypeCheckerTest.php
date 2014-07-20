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
		$this->assert($this->dataTypeChecker->check(array(), 123), exactly_equals, 123);
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
			array(array("number"), 123),
			array(array("number"), 12.3),
			array(array("number"), '12.3'),
			array(array("bool"), true),
		);
	}

	/**
	 * @dataProvider dataTypes
	 */
	public function testDataTypes(array $types, $value)
	{
		$this->assert($value, exactly_equals, $this->dataTypeChecker->check($types, $value));
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
		$this->assert($this->dataTypeChecker->check(array('string'), new Attribute('foo')), exactly_equals, 'bar');
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
		$this->assert($this->dataTypeChecker->check(array(), 123), equals, 123);
	}

	public function testWillTrimBackslashOffClass()
	{
		$this->assert($this->dataTypeChecker->check(array('class'), '\My\Class'), equals, 'My\Class');
	}

	public function testWillNotTrimBackslashOffClassIfNotValidatingAgainstClass()
	{
		$this->assert($this->dataTypeChecker->check(array('string'), '\My\Class'), equals, '\My\Class');
	}

	public function testWillNotTrimBackslashOffClassIfAnyValueCanBeAccepted()
	{
		$this->assert($this->dataTypeChecker->check(array(), '\My\Class'), equals, '\My\Class');
	}

	public function testWillTrimBackslashOffClassWhenInAttribute()
	{
		$context = array(
			'foo' => '\Bar',
		);
		$this->dataTypeChecker->setContext($context);
		$this->assert($this->dataTypeChecker->check(array('class'), new Attribute('foo')), equals, 'Bar');
	}

	public function testStringsWillBeAcceptedForRegex()
	{
		$this->assertSame('/a/', $this->dataTypeChecker->check(array('regex'), '/a/'));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage integer not found in regex
	 */
	public function testNonStringsWillNotBeAcceptedForRegex()
	{
		$this->dataTypeChecker->check(array('regex'), 123);
	}
}
