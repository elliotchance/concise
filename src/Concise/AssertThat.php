<?php

function assert_that()
{
	global $_currentTestCase;
	call_user_func_array(array($_currentTestCase, 'assert'), func_get_args());
}
