<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockReturnSelf
{
	public function me()
	{
		return null;
	}
}

class MockBuilderReturnSelfTest extends TestCase
{
	public function testMethodsCanReturnSelf()
	{
		$mock = $this->mock('\Concise\Mock\MockReturnSelf')
		             ->stub('me')->andReturnSelf()
		             ->done();
		$this->assert($mock->me(), is_the_same_as, $mock);
	}
}
