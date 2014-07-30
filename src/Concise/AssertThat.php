<?php

use \Concise\TestCase;

function assert_that()
{
	global $_currentTestCase;
	if(!$_currentTestCase) {
		$_currentTestCase = new TestCase();
	}
	call_user_func_array(array($_currentTestCase, 'assert'), func_get_args());
}
