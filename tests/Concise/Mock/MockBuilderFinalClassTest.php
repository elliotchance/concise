<?php

namespace Concise\Mock;

use \Concise\TestCase;

final class MockFinalClass
{
}

class MockBuilderFinalClassTest extends TestCase
{
	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Class 'Concise\Mock\MockFinalClass' is final so it cannot be mocked.
	 */
	public function testFinalClassesCannotBeMocked()
	{
		$this->mock('\Concise\Mock\MockFinalClass')
		     ->done();
	}
}
