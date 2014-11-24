<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class IsUniqueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsUnique();
    }

    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->assert(array(), is_unique);
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->assertFailure(array(123, 456, 123), is_unique);
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
