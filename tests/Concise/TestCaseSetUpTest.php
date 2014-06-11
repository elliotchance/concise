<?php

namespace Concise;

class TestCaseSetUpTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->xyz = 456;
	}

	public function _test_can_use_attributes_set_in_setUp()
	{
		return 'xyz equals 456';
	}
}
