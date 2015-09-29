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
        $this->assertString('foobar')->containsCaseInsensitive('oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString()
    {
        $this->assertString('foobar')->containsCaseInsensitive('baz');
    }

    public function testIsNotSensitiveToCase()
    {
        $this->assertString('foobar')->containsCaseInsensitive('Foo');
    }

    public function testSuccessIfStringContainsASubstring1()
    {
        $this->assertString('foobar')->contains('oob');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testFailsIfSubstringDoesNotExistInString1()
    {
        $this->assertString('foobar')->contains('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsSensitiveToCase()
    {
        $this->assertString('foobar')->contains('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring2()
    {
        $this->assertString('foobar')->doesNotContainCaseInsensitive('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString2()
    {
        $this->assertString('foobar')->doesNotContainCaseInsensitive('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testIsNotSensitiveToCase1()
    {
        $this->assertString('foobar')->doesNotContainCaseInsensitive('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSuccessIfStringContainsASubstring3()
    {
        $this->assertString('foobar')->doesNotContain('oob');
    }

    public function testFailsIfSubstringDoesNotExistInString3()
    {
        $this->assertString('foobar')->doesNotContain('baz');
    }

    public function testIsSensitiveToCase1()
    {
        $this->assertString('foobar')->doesNotContain('Foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithNoCharactersIsBlank()
    {
        $this->assertString('')->isNotEmpty;
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->assertString('a')->isNotEmpty;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringWithNoCharactersIsBlank1()
    {
        $this->assertString('')->isNotEmpty;
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank1()
    {
        $this->assertString('a')->isNotEmpty;
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->assertString("abc")->doesNotEndWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->assertString("abc")->doesNotEndWith("a");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotEndWithFailure()
    {
        $this->assertString("abc")->doesNotEndWith("abc");
    }

    public function testNeedleLongerThanHaystack1()
    {
        $this->assertString("abc")->doesNotStartWith("abcd");
    }

    public function testStringDoesNotStartWithAnotherString1()
    {
        $this->assertString("abc")->doesNotStartWith("c");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringDoesNotStartWithFailure()
    {
        $this->assertString("abc")->doesNotStartWith("abc");
    }

    public function testBasicString()
    {
        $this->assertString("abc")->endsWith("bc");
    }

    public function testStringsAreEqual()
    {
        $this->assertString("abc")->endsWith("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringEndsWithFailure()
    {
        $this->assertString("abc")->endsWith("ab");
    }

    public function testBasicString1()
    {
        $this->assertString("abc")->startsWith("ab");
    }

    public function testStringsAreEqual1()
    {
        $this->assertString("abc")->startsWith("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testStringStartsWithFailure()
    {
        $this->assertString("abc")->startsWith("abcd");
    }
}
