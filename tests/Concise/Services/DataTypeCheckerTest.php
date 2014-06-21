<?php

namespace Concise\Services;

use \Concise\Syntax\Token\Attribute;
use \Concise\Syntax\Token\Regexp;

class DataTypeCheckerTest extends \Concise\TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->dataTypeChecker = new DataTypeChecker();
	}

	public function testBlankAcceptsAnything()
	{
		$this->assert('`$self->dataTypeChecker->check(array(), 123)` is true');
	}

	public function testSendingValueOfDifferentExpectedTypeThrowsException()
	{
		$self = $this;
		$this->sendingValueOfDifferentExpectedType = function() use ($self) {
			$self->dataTypeChecker->check(array("int"), 1.23);
		};
		$this->assert('sendingValueOfDifferentExpectedType throws exception');
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
			array(array("class"), '\Concise\Syntax\Token\Regexp'),
		);
	}

	/**
	 * @dataProvider dataTypes
	 */
	public function testDataTypes(array $types, $value)
	{
		$this->types = $types;
		$this->value = $value;
		$this->assert('`$self->dataTypeChecker->check($self->types, $self->value)` is true');
	}

	public function testSendingValueNotListedInExpectedTypesThrowsException()
	{
		$self = $this;
		$this->sendingValueNotListedInExpectedTypes = function() use ($self) {
			$self->dataTypeChecker->check(array("int", "string"), 1.23);
		};
		$this->assert('sendingValueNotListedInExpectedTypes throws exception');
	}

	public function testExcludeModeWillNotAllowType()
	{
		$self = $this;
		$this->block = function() use ($self) {
			$self->dataTypeChecker->setExcludeMode();
			$self->dataTypeChecker->check(array("int"), 123);
		};
		$this->assert('block throws exception');
	}

	public function testAttributesAreEvaluatedFromContext()
	{
		$context = array(
			'foo' => 'bar',
		);
		$this->dataTypeChecker->setContext($context);
		$this->assertTrue($this->dataTypeChecker->check(array('string'), new Attribute('foo')));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Attribute 'foo' does not exist.
	 */
	public function testWillThrowExceptionIfAttributeDoesNotExist()
	{
		$this->assertTrue($this->dataTypeChecker->check(array('string'), new Attribute('foo')));
	}

	public function testExcludeWithEmptyArrayAllowsAnything()
	{
		$this->dataTypeChecker->setExcludeMode();
		$this->assertTrue($this->dataTypeChecker->check(array(), 123));
	}
}
