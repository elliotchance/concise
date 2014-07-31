<?php

use \Concise\TestCase;

function assert_that()
{
	global $_currentTestCase;
	if(!$_currentTestCase) {
		return call_user_func_array(array(new TestCase(), 'assert'), func_get_args());
	}
	call_user_func_array(array($_currentTestCase, 'assert'), func_get_args());
}
