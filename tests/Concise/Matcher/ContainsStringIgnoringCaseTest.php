<?php

namespace Concise\Matcher;

class ContainsStringIgnoringCaseTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ContainsStringIgnoringCase();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->assert('foobar', contains_string, 'oob', ignoring_case);
    }

    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assertFailure('foobar', contains_string, 'baz', ignoring_case);
    }

    public function testIsNotSensitiveToCase()
    {
        $this->assert('foobar', contains_string, 'Foo', ignoring_case);
    }
}
