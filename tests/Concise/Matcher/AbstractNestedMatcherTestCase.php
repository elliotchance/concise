<?php

namespace Concise\Matcher;

abstract class AbstractNestedMatcherTestCase extends AbstractMatcherTestCase
{
    /**
     * @group #219
     */
    public function testThisMatcherCanBeNested()
    {
        $this->assert(
            $this->matcher,
            is_instance_of,
            '\Concise\Matcher\AbstractNestedMatcher'
        );
    }

    abstract public function testNestedAssertionSuccess();

    abstract public function testNestedAssertionFailure();
}
