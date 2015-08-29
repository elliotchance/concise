<?php

namespace Concise\Matcher;

abstract class AbstractNestedMatcherTestCase extends AbstractMatcherTestCase
{
    /**
     * @group #219
     */
    public function testThisMatcherCanBeNested()
    {
        $this->aassert($this->matcher)
            ->isInstanceOf('\Concise\Matcher\AbstractNestedMatcher');
    }

    abstract public function testNestedAssertionSuccess();

    abstract public function testNestedAssertionFailure();
}
