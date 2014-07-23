<?php

namespace Concise\Mock;

use \Concise\TestCase;

final class MockFinalClass
{
}

class MockFinalClass2
{
	public final function myMethod()
	{
	}
}

class MockBuilderFinalClassTest extends TestCase
{
	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Class Concise\Mock\MockFinalClass is final so it cannot be mocked.
	 */
	public function testFinalClassesCannotBeMocked()
	{
		$this->mock('\Concise\Mock\MockFinalClass')
		     ->done();
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Method Concise\Mock\MockFinalClass2::myMethod() is final so it cannot be mocked.
	 */
	public function testFinalMethodsCannotBeMocked()
	{
		$this->mock('\Concise\Mock\MockFinalClass2')
		     ->stub('myMethod')
		     ->done();
	}
}
