<?php

namespace Concise;

class VerifyTest extends TestCase
{
    /**
     * @group #216
     */
    public function testSuccessfulVerifyReturnsTrue()
    {
        $this->assert($this->verify(true), is_true);
    }
}
