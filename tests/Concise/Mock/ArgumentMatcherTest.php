<?php

namespace Concise\Mock;

use Concise\TestCase;

class ArgumentMatcherTest extends TestCase
{
    public function testMatchingZeroArgumentsReturnsTrue()
    {
        $matcher = new ArgumentMatcher();
        $this->assert($matcher->match(array(), array()));
    }
}
