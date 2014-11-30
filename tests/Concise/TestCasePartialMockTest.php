<?php

namespace Concise;

use DateTime;

/**
 * @group mocking
 * @group #129
 */
class TestCasePartialMockTest extends TestCase
{
    public function testPartialMockReturnsMockBuilder()
    {
        $instance = new DateTime();
        $this->assert($this->partialMock($instance), instance_of, '\Concise\Mock\MockBuilder');
    }
}
