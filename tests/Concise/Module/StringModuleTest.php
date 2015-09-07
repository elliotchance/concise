<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class StringModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringModule();
    }

    public function testSuccessIfStringContainsASubstring()
    {
        $this->aassert('foobar')->containsCaseInsensitiveString('oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->aassert('foobar')->containsCaseInsensitiveString('baz');
    }

    public function testIsNotSensitiveToCase()
    {
        $this->aassert('foobar')->containsCaseInsensitiveString('Foo');
    }

    public function testSuccessIfStringContainsASubstring1()
    {
        $this->assert('foobar', contains_string, 'oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString1()
    {
        $this->aassert('foobar')->containsString('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsSensitiveToCase()
    {
        $this->aassert('foobar')->containsString('Foo');
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
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring2()
    {
        $this->aassert('foobar')->doesNotContainCaseInsensitiveString('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString2()
    {
        $this->aassert('foobar')->doesNotContainCaseInsensitiveString('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotSensitiveToCase1()
    {
        $this->aassert('foobar')->doesNotContainCaseInsensitiveString('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring3()
    {
        $this->aassert('foobar')->doesNotContainString('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString3()
    {
        $this->assert('foobar', does_not_contain_string, 'baz');
    }

    public function testIsSensitiveToCase1()
    {
        $this->assert('foobar', does_not_contain_string, 'Foo');
    }

    public function testStringWithNoCharactersIsBlank()
    {
        $this->assert('', is_blank);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->aassert('a')->isBlank;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithNoCharactersIsBlank1()
    {
        $this->aassert('')->isNotBlank;
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

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotEndWithFailure()
    {
        $this->aassert("abc")->doesNotEndWith("abc");
    }

    public function testNeedleLongerThanHaystack1()
    {
        $this->assert('"abc" does not start with "abcd"');
    }

    public function testStringDoesNotStartWithAnotherString1()
    {
        $this->assert('"abc" does not start with "c"');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotStartWithFailure()
    {
        $this->aassert("abc")->doesNotStartWith("abc");
    }

    public function testBasicString()
    {
        $this->assert('"abc" ends with "bc"');
    }

    public function testStringsAreEqual()
    {
        $this->assert('"abc" ends with "abc"');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringEndsWithFailure()
    {
        $this->aassert("abc")->endsWith("ab");
    }

    public function testBasicString1()
    {
        $this->assert('"abc" starts with "ab"');
    }

    public function testStringsAreEqual1()
    {
        $this->assert('"abc" starts with "abc"');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringStartsWithFailure()
    {
        $this->aassert("abc")->startsWith("abcd");
    }
}
