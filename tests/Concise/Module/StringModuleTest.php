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
        $this->aassert('foobar')->containsString('oob');
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
        /*$this->assert('foobar', does_not_contain_string, 'baz');*/
        $this->aassert('foobar')->doesNotContainString('baz');
    }

    public function testIsSensitiveToCase1()
    {
        /*$this->assert('foobar', does_not_contain_string, 'Foo');*/
        $this->aassert('foobar')->doesNotContainString('Foo');
    }

    public function testStringWithNoCharactersIsBlank()
    {
        /*$this->assert('', is_blank);*/
        $this->aassert('')->isBlank;
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
        $this->aassert('a')->isNotBlank;
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->aassert("abc")->doesNotEndWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->aassert("abc")->doesNotEndWith("a");
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
        $this->aassert("abc")->doesNotStartWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString1()
    {
        $this->aassert("abc")->doesNotStartWith("c");
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
        $this->aassert("abc")->endsWith("bc");
    }

    public function testStringsAreEqual()
    {
        $this->aassert("abc")->endsWith("abc");
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
        $this->aassert("abc")->startsWith("ab");
    }

    public function testStringsAreEqual1()
    {
        $this->aassert("abc")->startsWith("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringStartsWithFailure()
    {
        $this->aassert("abc")->startsWith("abcd");
    }
}
