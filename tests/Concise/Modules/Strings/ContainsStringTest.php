<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractNestedMatcherTestCase;

/**
 * @group matcher
 */
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

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert('foobar', contains_string, 'oob'),
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
            $this->assert('foobar', contains_string, 'oob'),
            exactly_equals,
            'Foo'
        );
    }
}
