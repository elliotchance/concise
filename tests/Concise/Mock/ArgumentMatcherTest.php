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
        $this->aassert($this->matcher->match(array(), array()))->isTrue;
    }

    public function testMatchingArraysOfDifferentSizesReturnsFalse()
    {
        $this->aassert($this->matcher->match(array(), array('a')))->isFalse;
    }

    public function testMatchingWithOneValueThatIsDifferentReturnsFalse()
    {
        $this->aassert($this->matcher->match(array('b'), array('a')))->isFalse;
    }

    public function testMatchingIsNotExact()
    {
        $this->aassert($this->matcher->match(array(0), array(false)))->isTrue;
    }

    public function testMatchingMoreThanOneItemWhereOnlyOneIsDifferentReturnsFalse()
    {
        $this->aassert(
            $this->matcher->match(array('a', 'b'), array('a', 'a'))
        )->isFalse;
    }

    public function testExpectedIsAllowedToContainAnythingConstant()
    {
        $this->aassert(
            $this->matcher->match(array('a', self::ANYTHING), array('a', 'a'))
        )->isTrue;
    }
}
