<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class StringModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringModule();
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

    public function testSuccessIfStringContainsASubstring1()
    {
        $this->assert('foobar', contains_string, 'oob');
    }

    public function testFailsIfSubstringDoesNotExistInString1()
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
    public function testNestedAssertionSuccess1()
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
    public function testNestedAssertionFailure1()
    {
        $this->assertFailure(
            $this->assert('foobar', contains_string, 'oob'),
            exactly_equals,
            'Foo'
        );
    }

    public function testSuccessIfStringContainsASubstring2()
    {
        $this->assertFailure(
            'foobar',
            does_not_contain_string,
            'oob',
            ignoring_case
        );
    }

    public function testFailsIfSubstringDoesNotExistInString2()
    {
        $this->assert('foobar', does_not_contain_string, 'baz', ignoring_case);
    }

    public function testIsNotSensitiveToCase1()
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
    public function testNestedAssertionSuccess2()
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
    public function testNestedAssertionFailure2()
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

    public function testSuccessIfStringContainsASubstring3()
    {
        $this->assertFailure('foobar', does_not_contain_string, 'oob');
    }

    public function testFailsIfSubstringDoesNotExistInString3()
    {
        $this->assert('foobar', does_not_contain_string, 'baz');
    }

    public function testIsSensitiveToCase1()
    {
        $this->assert('foobar', does_not_contain_string, 'Foo');
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess3()
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
    public function testNestedAssertionFailure3()
    {
        $this->assertFailure(
            $this->assert('foobar', does_not_contain_string, 'baz'),
            exactly_equals,
            'Foo'
        );
    }

    public function testStringWithNoCharactersIsBlank()
    {
        $this->assert('', is_blank);
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->assertFailure('a', is_blank);
    }

    public function testStringWithNoCharactersIsBlank1()
    {
        $this->assertFailure('', is_not_blank);
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank1()
    {
        $this->assert('a', is_not_blank);
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->assert('"abc" does not end with "abcd"');
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->assert('"abc" does not end with "a"');
    }

    public function testStringDoesNotEndWithFailure()
    {
        $this->assertFailure('"abc" does not end with "abc"');
    }

    public function testNeedleLongerThanHaystack1()
    {
        $this->assert('"abc" does not start with "abcd"');
    }

    public function testStringDoesNotStartWithAnotherString1()
    {
        $this->assert('"abc" does not start with "c"');
    }

    public function testStringDoesNotStartWithFailure()
    {
        $this->assertFailure('"abc" does not start with "abc"');
    }

    public function testBasicString()
    {
        $this->assert('"abc" ends with "bc"');
    }

    public function testStringsAreEqual()
    {
        $this->assert('"abc" ends with "abc"');
    }

    public function testStringEndsWithFailure()
    {
        $this->assertFailure('"abc" ends with "ab"');
    }

    public function testBasicString1()
    {
        $this->assert('"abc" starts with "ab"');
    }

    public function testStringsAreEqual1()
    {
        $this->assert('"abc" starts with "abc"');
    }

    public function testStringStartsWithFailure()
    {
        $this->assertFailure('"abc" starts with "abcd"');
    }
}