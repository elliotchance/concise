<?php

namespace Concise\Mock;

use Concise\TestCase;

class ArgumentMatcherTest extends TestCase
{
    protected $matcher;

    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ArgumentMatcher();
    }

    public function testMatchingZeroArgumentsReturnsTrue()
    {
        $this->assert($this->matcher->match(array(), array()));
    }

    public function testMatchingArraysOfDifferentSizesReturnsFalse()
    {
        $this->assert($this->matcher->match(array(), array('a')), is_false);
    }

    public function testMatchingWithOneValueThatIsDifferentReturnsFalse()
    {
        $this->assert($this->matcher->match(array('b'), array('a')), is_false);
    }

    public function testMatchingIsNotExact()
    {
        $this->assert($this->matcher->match(array(0), array(false)), is_true);
    }

    public function testMatchingMoreThanOneItemWhereOnlyOneIsDifferentReturnsFalse(
    )
    {
        $this->assert(
            $this->matcher->match(array('a', 'b'), array('a', 'a')),
            is_false
        );
    }

    public function testExpectedIsAllowedToContainAnythingConstant()
    {
        $this->assert(
            $this->matcher->match(array('a', self::ANYTHING), array('a', 'a')),
            is_true
        );
    }
}
