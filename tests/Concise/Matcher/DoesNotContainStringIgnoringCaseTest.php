<?php

namespace Concise\Matcher;

class DoesNotContainStringIgnoringCaseTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotContainStringIgnoringCase();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->assertFailure('foobar', does_not_contain_string, 'oob', ignoring_case);
    }

    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assert('foobar', does_not_contain_string, 'baz', ignoring_case);
    }

    public function testIsNotSensitiveToCase()
    {
        $this->assertFailure('foobar', does_not_contain_string, 'Foo', ignoring_case);
    }

    public function tags()
    {
        return array(Tag::STRINGS);
    }
}
