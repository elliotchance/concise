<?php

namespace Concise\Mock;

use Concise\Core\TestCase;
use PHPUnit\Framework\AssertionFailedError;

class DummyMock implements MockInterface
{
    public function getCallsForMethod($method)
    {
    }
}

/**
 * @group mocking
 * @group #155
 */
class MockVerifyTest extends TestCase
{
    public function testManuallyVerifyingAMockWillReturnTrue()
    {
        $mock = $this->mock()->get();
        $this->assert($this->assertMock($mock))->isTrue;
    }

    public function testWillThrowExceptionIfMockDoesNotSatifyRequirements()
    {
        $mock = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $self = $this;
        $this->assertClosure(
            function () use ($mock, $self) {
                $self->assertMock($mock);
            }
        )->throws(AssertionFailedError::class);
    }

    public function testAssertingASecondaryMock()
    {
        $this->mock()->get();
        $mock2 = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $self = $this;
        $this->assertClosure(
            function () use ($mock2, $self) {
                $self->assertMock($mock2);
            }
        )->throws(AssertionFailedError::class);
    }

    public function testAssertingAMockDoesNotRemoveItFromTheManager()
    {
        $mock1 = $this->mock()->get();
        $this->mock()->get();
        $this->assertMock($mock1);
        $this->assert(count($this->mockManager->getMocks()))->equals(2);
    }

    public function testAssertingAMiddleMock()
    {
        $this->mock()->get();
        $mock2 = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $this->mock()->get();
        $self = $this;
        $this->assertClosure(
            function () use ($mock2, $self) {
                $self->assertMock($mock2);
            }
        )->throws(AssertionFailedError::class);
    }

    /**
     * @expectedException \PHPUnit\Framework\AssertionFailedError
     * @expectedExceptionMessage You cannot assert a mock more than once.
     */
    public function testYouCannotAssertAMockTwice()
    {
        $mock = $this->mock()->get();
        $this->assertMock($mock);
        $this->assertMock($mock);
    }

    /**
     * @expectedException \PHPUnit\Framework\AssertionFailedError
     * @expectedExceptionMessage No such mock in mock manager.
     */
    public function testWillThrowExceptionIfMockBeingVerifiedDoesNotExist()
    {
        $this->assertMock(new DummyMock());
    }
}
