<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class FalseTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new False();
    }

    public function testAlwaysFails()
    {
        $this->assertFailure('false');
    }

    public function tags()
    {
        return array(Tag::BOOLEANS);
    }
}
