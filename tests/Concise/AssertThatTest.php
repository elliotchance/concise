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

	public function testAssertThatCurrentTestCaseWillBeSetToNullOnTearDown()
	{
		global $_currentTestCase;
		$this->tearDown();
		$this->assert($_currentTestCase, is_null);
	}
}
