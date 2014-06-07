<?php

namespace Concise;

class TestCasePrepareTest extends TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->abc = 123;
	}

	public function setUp()
	{
		parent::setUp();
		$this->xyz = 456;
	}

	public function _test_can_use_attributes_set_in_prepare()
	{
		return 'abc equals 123';
	}

	public function _test_can_use_attributes_set_in_setUp()
	{
		return 'xyz equals 456';
	}
}
