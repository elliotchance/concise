<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class TrueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new True();
    }

    public function testTrue()
    {
        $this->assert('true');
    }

    public function tags()
    {
        return array(Tag::BOOLEANS);
    }
}
