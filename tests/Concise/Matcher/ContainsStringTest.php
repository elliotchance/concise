<?php

namespace Concise\Matcher;

class ContainsStringTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ContainsString();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->assert('foobar', contains_string, 'oob');
    }

    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assertFailure('foobar', contains_string, 'baz');
    }

    public function testIsSensitiveToCase()
    {
        $this->assertFailure('foobar', contains_string, 'Foo');
    }

    public function tags()
    {
        return array(Tag::STRINGS);
    }

    public function testNestedAssertionSuccess()
    {
        $this->assert($this->assert('foobar', contains_string, 'oob'), exactly_equals, 'foobar');
    }

    public function testNestedAssertionFailure()
    {
        $this->assertFailure($this->assert('foobar', contains_string, 'oob'), exactly_equals, 'Foo');
    }
}
