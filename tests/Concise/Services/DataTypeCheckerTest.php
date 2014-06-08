<?php

namespace Concise\Services;

class DataTypeCheckerTest extends \Concise\TestCase
{
	public function _test_blank_accepts_anything()
	{
		$this->dataTypeChecker = new DataTypeChecker();
		return '`$self->dataTypeChecker->check("", 123)` is true';
	}
}
