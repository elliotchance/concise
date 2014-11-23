<?php

namespace Concise\Mock;

use Concise\TestCase;

/**
 * @group mocking
 * @group #155
 */
class MockVerifyTest extends TestCase
{
	public function testManuallyVerifyingAMockWillReturnTrue()
	{
		$mock = $this->mock()->get();
		$this->assert($this->assertMock($mock), is_true);
	}

	public function testWillThrowExceptionIfMockDoesNotSatifyRequirements()
	{
		$mock = $this->mock('\DateTime')
			->expect('getLastErrors')
			->get();
		$this->assert(function () use ($mock) {
			$this->assertMock($mock);
		}, throws, '\PHPUnit_Framework_AssertionFailedError');
	}
}
