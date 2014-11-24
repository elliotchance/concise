<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsFalsyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsFalsy();
    }

    public function testFalseIsFalsy()
    {
        $this->assert(false, is_falsy);
    }

    public function testTrueIsNotFalsy()
    {
        $this->assertFailure(true, is_falsy);
    }

    public function testZeroIsFalsy()
    {
        $this->assert(0, is_falsy);
    }

    public function tags()
    {
        return array(Tag::BOOLEANS, Tag::TYPES);
    }
}
