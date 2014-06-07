<?php

namespace Concise;

class TestCasePrepareTest extends TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->abc = 123;
	}

	public function _test_can_use_attributes_set_in_prepare()
	{
		return 'abc equals 123';
	}
}
