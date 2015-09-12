<?php

namespace Concise\Services;

use Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
    public function testCanFindAssertionWithArguments()
    {
        $assertion = $this->getAssertionWithArgs(array(123, 'equals', 123));
        $this->assert($assertion->getMatcher())->instanceOf('\Concise\Module\BasicModule');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such matcher for syntax '? array ?' or
     *     'equals ? string'.
     */
    public function testWillThrowExceptionIfAssertionCannotBeFound()
    {
        $builder = new AssertionBuilder(array('equals', 'array', 'string'));
        $builder->getAssertion();
    }

    public function testAssertionBuilderWillAcceptTrueFollowedByOtherArguments()
    {
        $assertion = $this->getAssertionWithArgs(array(true, 'is true'));
        $this->assert($assertion->getMatcher())->notInstanceOf('\Concise\Module\BasicModule');
    }

    public function testAssertionBuilderWillAcceptFalseFollowedByOtherArguments()
    {
        $assertion = $this->getAssertionWithArgs(array(false, 'is false'));
        $this->assert($assertion->getMatcher())->notInstanceOf('\Concise\Module\BasicModule');
    }

    protected function getAssertionWithArgs(array $args)
    {
        $builder = new AssertionBuilder($args);

        return $builder->getAssertion();
    }

    /**
     * @expectedException \Concise\Syntax\NoMatcherFoundException
     */
    public function testWillThrowNoMatcherFoundException()
    {
        $builder = new AssertionBuilder(array('foo', 'array', 123));
        $builder->getAssertion();
    }
}
