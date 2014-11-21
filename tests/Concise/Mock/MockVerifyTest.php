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
		$this->assert($this->verifyMock($mock), is_true);
	}
}
