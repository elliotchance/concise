<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcherTestCase;

/**
 * @group matcher
 */
class DoesNotContainStringTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotContainString();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->assertFailure('foobar', does_not_contain_string, 'oob');
    }

    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assert('foobar', does_not_contain_string, 'baz');
    }

    public function testIsSensitiveToCase()
    {
        $this->assert('foobar', does_not_contain_string, 'Foo');
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert('foobar', does_not_contain_string, 'baz'),
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
            $this->assert('foobar', does_not_contain_string, 'baz'),
            exactly_equals,
            'Foo'
        );
    }
}
