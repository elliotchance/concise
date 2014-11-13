<?php

namespace Concise\Matcher;

abstract class AbstractNestedMatcherTestCase extends AbstractMatcherTestCase
{
    public function testThisMatcherCanBeNested()
    {
        $this->assert($this->matcher, is_instance_of, '\Concise\Matcher\AbstractNestedMatcher');
    }
}
