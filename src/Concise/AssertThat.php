<?php

use \Concise\TestCase;

function assert_that()
{
	global $_currentTestCase;
	if(!$_currentTestCase) {
		$testCase = new TestCase();
		$testCase->setUp();
		$r = call_user_func_array(array($testCase, 'assert'), func_get_args());
		$testCase->tearDown();
		return $r;
	}
	call_user_func_array(array($_currentTestCase, 'assert'), func_get_args());
}
