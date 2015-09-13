<?php

namespace Concise\Mock;

use Concise\Core\TestCase;

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
        $this->assert($this->matcher->match(array(), array()))->isTrue;
    }

    public function testMatchingArraysOfDifferentSizesReturnsFalse()
    {
        $this->assert($this->matcher->match(array(), array('a')))->isFalse;
    }

    public function testMatchingWithOneValueThatIsDifferentReturnsFalse()
    {
        $this->assert($this->matcher->match(array('b'), array('a')))->isFalse;
    }

    public function testMatchingIsNotExact()
    {
        $this->assert($this->matcher->match(array(0), array(false)))->isTrue;
    }

    public function testMatchingMoreThanOneItemWhereOnlyOneIsDifferentReturnsFalse()
    {
        $this->assert(
            $this->matcher->match(array('a', 'b'), array('a', 'a'))
        )->isFalse;
    }

    public function testExpectedIsAllowedToContainAnythingConstant()
    {
        $this->assert(
            $this->matcher->match(array('a', self::ANYTHING), array('a', 'a'))
        )->isTrue;
    }
}
