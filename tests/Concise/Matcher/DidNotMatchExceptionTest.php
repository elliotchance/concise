<?php

namespace Concise\Matcher;

class DidNotMatchExceptionTest extends \Concise\TestCase
{
	public function _test_is_a_type_of_Exception()
	{
		return '`new \Concise\Matcher\DidNotMatchException()` is an instance of \Exception';
	}
}
