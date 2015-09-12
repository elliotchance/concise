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
        $this->assert('foobar')->containsCaseInsensitiveString('oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assert('foobar')->containsCaseInsensitiveString('baz');
    }

    public function testIsNotSensitiveToCase()
    {
        $this->assert('foobar')->containsCaseInsensitiveString('Foo');
    }

    public function testSuccessIfStringContainsASubstring1()
    {
        $this->assert('foobar')->containsString('oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString1()
    {
        $this->assert('foobar')->containsString('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsSensitiveToCase()
    {
        $this->assert('foobar')->containsString('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring2()
    {
        $this->assert('foobar')->doesNotContainCaseInsensitiveString('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString2()
    {
        $this->assert('foobar')->doesNotContainCaseInsensitiveString('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotSensitiveToCase1()
    {
        $this->assert('foobar')->doesNotContainCaseInsensitiveString('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring3()
    {
        $this->assert('foobar')->doesNotContainString('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString3()
    {
        /*$this->assert('foobar', does_not_contain_string, 'baz');*/
        $this->assert('foobar')->doesNotContainString('baz');
    }

    public function testIsSensitiveToCase1()
    {
        /*$this->assert('foobar', does_not_contain_string, 'Foo');*/
        $this->assert('foobar')->doesNotContainString('Foo');
    }

    public function testStringWithNoCharactersIsBlank()
    {
        /*$this->assert('', is_blank);*/
        $this->assert('')->isBlank;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->assert('a')->isBlank;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithNoCharactersIsBlank1()
    {
        $this->assert('')->isNotBlank;
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank1()
    {
        $this->assert('a')->isNotBlank;
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->assert("abc")->doesNotEndWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->assert("abc")->doesNotEndWith("a");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotEndWithFailure()
    {
        $this->assert("abc")->doesNotEndWith("abc");
    }

    public function testNeedleLongerThanHaystack1()
    {
        $this->assert("abc")->doesNotStartWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString1()
    {
        $this->assert("abc")->doesNotStartWith("c");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotStartWithFailure()
    {
        $this->assert("abc")->doesNotStartWith("abc");
    }

    public function testBasicString()
    {
        $this->assert("abc")->endsWith("bc");
    }

    public function testStringsAreEqual()
    {
        $this->assert("abc")->endsWith("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringEndsWithFailure()
    {
        $this->assert("abc")->endsWith("ab");
    }

    public function testBasicString1()
    {
        $this->assert("abc")->startsWith("ab");
    }

    public function testStringsAreEqual1()
    {
        $this->assert("abc")->startsWith("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringStartsWithFailure()
    {
        $this->assert("abc")->startsWith("abcd");
    }
}
