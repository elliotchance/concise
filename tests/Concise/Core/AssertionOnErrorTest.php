<?php

namespace Concise\Core;

class AssertionOnErrorTest extends TestCase
{
    public function testMessageCanBeAddedToAnAssertion()
    {
        $this->assert('foo', 123)->equals(123);
    }

    public function testWillUseOnErrorMessage()
    {
        try {
            $this->assert('foo', 123)->equals(124);
            $this->fail('Did not fail.');
        } catch (DidNotMatchException $e) {
            $this->assert($e->getMessage())->equals('foo: 123 equals 124');
        }
    }

    /**
     * @group #231
     */
    public function testOnErrorWorksWhenUsingItImmediatelyAfterAnotherConstant()
    {
        $this->assert("Oops", true)->isTrue;
    }
}
