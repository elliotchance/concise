<?php

namespace Concise;

/**
 * When using concise with non-PHPUnit it has to still remain compatible
 */
class MyTinyTestSuite
{
	use \Concise;

	public function checkSomething()
	{
		$this->assert(3 + 5, equals, 8);
	}
}

class TestCaseExternalTest extends \PHPUnit_Framework_TestCase
{
	public function testAnExternalRunner()
	{
		$suite = new MyTinyTestSuite();
		$suite->checkSomething();
	}
}
