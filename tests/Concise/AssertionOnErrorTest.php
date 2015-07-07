<?php

namespace Concise;

use PHPUnit_Framework_AssertionFailedError;

class AssertionOnErrorTest extends TestCase
{
    public function testOnErrorMustBeDefined()
    {
        $this->assert(defined('on_error'));
    }

    public function testOnErrorCanBeAddedToTheEndOfAnAssertion()
    {
        $this->assert(123, equals, 123, on_error, 'foo');
    }

    public function testWillUseOnErrorMessage()
    {
        try {
            $this->assert(123, equals, 124, on_error, 'foo');
            $this->fail('Did not fail.');
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage(), equals, 'foo');
        }
    }

    /**
     * @group #231
     */
    public function testOnErrorWorksWhenUsingItImmediatelyAfterAnotherConstant()
    {
        $this->assert(true, is_true, on_error, "Oops");
    }
}
