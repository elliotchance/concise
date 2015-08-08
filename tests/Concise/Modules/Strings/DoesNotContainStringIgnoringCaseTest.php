<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcherTestCase;

/**
 * @group matcher
 */
class DoesNotContainStringIgnoringCaseTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotContainStringIgnoringCase();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->assertFailure(
            'foobar',
            does_not_contain_string,
            'oob',
            ignoring_case
        );
    }

    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assert('foobar', does_not_contain_string, 'baz', ignoring_case);
    }

    public function testIsNotSensitiveToCase()
    {
        $this->assertFailure(
            'foobar',
            does_not_contain_string,
            'Foo',
            ignoring_case
        );
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert(
                'foobar',
                does_not_contain_string,
                'baz',
                ignoring_case
            ),
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
            $this->assert(
                'foobar',
                does_not_contain_string,
                'baz',
                ignoring_case
            ),
            exactly_equals,
            'Foo'
        );
    }
}
