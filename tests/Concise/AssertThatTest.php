<?php

namespace Concise;

class AssertThatTest extends TestCase
{
	public function testAssertThatWillStillWorkIfNoTestCaseIsSetup()
	{
		global $_currentTestCase;
		$_currentTestCase = null;
		assert_that(true);
	}
}
