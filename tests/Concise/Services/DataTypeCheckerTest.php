<?php

namespace Concise\Services;

class DataTypeCheckerTest extends \Concise\TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->dataTypeChecker = new DataTypeChecker();
	}

	public function _test_blank_accepts_anything()
	{
		return '`$self->dataTypeChecker->check(array(), 123)` is true';
	}

	public function _test_sendingValueOfDifferentExpectedType_throws_exception()
	{
		$self = $this;
		$this->sendingValueOfDifferentExpectedType = function() use ($self) {
			$self->dataTypeChecker->check(array("int"), 1.23);
		};
	}

	public function _test_check()
	{
		$data = array(
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
		);
		return $this->assertionsForDataSet('`$self->dataTypeChecker->check(?, ?)` is true', $data);
	}

	public function _test_sendingValueNotListedInExpectedTypes_throws_exception()
	{
		$self = $this;
		$this->sendingValueNotListedInExpectedTypes = function() use ($self) {
			$self->dataTypeChecker->check(array("int", "string"), 1.23);
		};
	}

	public function _test_exclude_mode_will_not_allow_type()
	{
		$self = $this;
		$this->block = function() use ($self) {
			$self->dataTypeChecker->setExcludeMode();
			$self->dataTypeChecker->check(array("int"), 123);
		};
		return 'block throws exception';
	}
}
