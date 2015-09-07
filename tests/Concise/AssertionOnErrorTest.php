<?php

namespace Concise;

use Concise\Core\DidNotMatchException;

class AssertionOnErrorTest extends TestCase
{
    public function testMessageCanBeAddedToAnAssertion()
    {
        $this->aassert('foo', 123)->equals(123);
    }

    public function testWillUseOnErrorMessage()
    {
        try {
            $this->aassert('foo', 123)->equals(124);
            $this->fail('Did not fail.');
        } catch (DidNotMatchException $e) {
            $this->aassert($e->getMessage())->equals('foo');
        }
    }

    /**
     * @group #231
     */
    public function testOnErrorWorksWhenUsingItImmediatelyAfterAnotherConstant()
    {
        $this->aassertTrue("Oops", true)->isTrue;
    }
}
