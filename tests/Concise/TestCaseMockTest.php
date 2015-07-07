<?php

namespace Concise;

/**
 * @group mocking
 */
class TestCaseMockTest extends TestCase
{
    public function testMocksAreResetInTheSetup()
    {
        $this->assert(
            $this->getMockManager()->getMocks(),
            exactly_equals,
            array()
        );
    }

    public function testCreatingAMockAddsItToTheMocks()
    {
        $this->mock()->get();
        $this->assert(count($this->getMockManager()->getMocks()), equals, 1);
    }

    public function testCreatingANiceMockAddsItToTheMocks()
    {
        $this->niceMock()->get();
        $this->assert(count($this->getMockManager()->getMocks()), equals, 1);
    }

    public function testCreatingMultipleMocksAddsAllToMocks()
    {
        $this->mock()->get();
        $this->niceMock()->get();
        $this->assert(count($this->getMockManager()->getMocks()), equals, 2);
    }

    public function testCallingDoneTwiceWillGenerateTwoMocksAndBothWillBeRegistered(
    )
    {
        $mockTemplate = $this->mock();
        $mockTemplate->get();
        $mockTemplate->get();
        $this->assert(count($this->getMockManager()->getMocks()), equals, 2);
    }
}
