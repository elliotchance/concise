<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class StringStartsWithTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringStartsWith();
    }

    public function testBasicString()
    {
        $this->assert('"abc" starts with "ab"');
    }

    public function testStringsAreEqual()
    {
        $this->assert('"abc" starts with "abc"');
    }

    public function testStringStartsWithFailure()
    {
        $this->assertFailure('"abc" starts with "abcd"');
    }

    public function tags()
    {
        return array();
    }
}
