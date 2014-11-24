<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsTruthyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsTruthy();
    }

    public function testFalseIsNotTruthy()
    {
        $this->assertFailure(false, is_truthy);
    }

    public function testTrueIsTruthy()
    {
        $this->assert(true, is_truthy);
    }

    public function testOneIsTruthy()
    {
        $this->assert(1, is_truthy);
    }

    public function tags()
    {
        return array(Tag::BOOLEANS, Tag::TYPES);
    }
}
