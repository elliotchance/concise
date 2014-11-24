<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsNotNullTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotNull();
    }

    public function testZeroIsNotNull()
    {
        $this->assert('0 is not null');
    }

    public function testABlankStringIsNotNull()
    {
        $this->assert('"" is not null');
    }

    public function testFalseIsNotNull()
    {
        $this->assert(false, is_not_null);
    }

    public function testIsNotNullFailure()
    {
        $this->assertFailure(null, is_not_null);
    }

    public function tags()
    {
        return array(Tag::TYPES);
    }
}
