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

    public function testMatchingArraysOfDifferentSizesReturnsFalse()
    {
        $matcher = new ArgumentMatcher();
        $this->assert($matcher->match(array(), array('a')), is_false);
    }

    public function testMatchingWithOneValueThatIsDifferentReturnsFalse()
    {
        $matcher = new ArgumentMatcher();
        $this->assert($matcher->match(array('b'), array('a')), is_false);
    }
}
