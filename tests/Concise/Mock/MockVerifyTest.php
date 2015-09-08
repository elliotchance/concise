<?php

namespace Concise\Mock;

use Concise\TestCase;

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
        $this->aassert($this->assertMock($mock))->isTrue;
    }

    public function testWillThrowExceptionIfMockDoesNotSatifyRequirements()
    {
        $mock = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $self = $this;
        $this->aassert(
            function () use ($mock, $self) {
                $self->assertMock($mock);
            }
        )->throws('PHPUnit_Framework_AssertionFailedError');
    }

    public function testAssertingASecondaryMock()
    {
        $this->mock()->get();
        $mock2 = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $self = $this;
        $this->aassert(
            function () use ($mock2, $self) {
                $self->assertMock($mock2);
            }
        )->throws('PHPUnit_Framework_AssertionFailedError');
    }

    public function testAssertingAMockDoesNotRemoveItFromTheManager()
    {
        $mock1 = $this->mock()->get();
        $this->mock()->get();
        $this->assertMock($mock1);
        $this->aassert(count($this->mockManager->getMocks()))->equals(2);
    }

    public function testAssertingAMiddleMock()
    {
        $this->mock()->get();
        $mock2 = $this->mock('\DateTime')->expect('getLastErrors')->get();
        $this->mock()->get();
        $self = $this;
        $this->aassert(
            function () use ($mock2, $self) {
                $self->assertMock($mock2);
            }
        )->throws('PHPUnit_Framework_AssertionFailedError');
    }

    /**
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage You cannot assert a mock more than once.
     */
    public function testYouCannotAssertAMockTwice()
    {
        $mock = $this->mock()->get();
        $this->assertMock($mock);
        $this->assertMock($mock);
    }

    /**
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage No such mock in mock manager.
     */
    public function testWillThrowExceptionIfMockBeingVerifiedDoesNotExist()
    {
        $this->assertMock(new DummyMock());
    }
}
