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
		return '`$self->dataTypeChecker->check("", 123)` is true';
	}

	public function _test_sendingValueOfDifferentExpectedType_throws_exception()
	{
		$this->sendingValueOfDifferentExpectedType = function() {
			$this->dataTypeChecker->check("int", 1.23);
		};
	}

	public function _test_check()
	{
		$data = array(
			array("int", 123),
			array("integer", 123),
			array("float", 1.23),
			array("double", 1.23),
			array("string", 'abc'),
			array("array", array()),
			array("resource", fopen('.', 'r')),
			array("object", new \stdClass()),
			array("int,float", 1.23),
		);
		return $this->assertionsForDataSet('`$self->dataTypeChecker->check(?, ?)` is true', $data);
	}

	public function _test_sendingValueNotListedInExpectedTypes_throws_exception()
	{
		$this->sendingValueNotListedInExpectedTypes = function() {
			$this->dataTypeChecker->check("int,string", 1.23);
		};
	}
}
