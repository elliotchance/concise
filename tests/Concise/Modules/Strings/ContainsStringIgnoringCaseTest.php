<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcherTestCase;

/**
 * @group matcher
 */
class ContainsStringIgnoringCaseTest extends AbstractNestedMatcherTestCase
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

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert('foobar', contains_string, 'Foo', ignoring_case),
            exactly_equals,
            'foobar'
        );
    }

    /**
     * @group #219
     */
    public function testNestedAssertionFailure()
    {
        $this->assertFailure(
            $this->assert('foobar', contains_string, 'Foo', ignoring_case),
            exactly_equals,
            'Foo'
        );
    }
}
