<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class ArrayModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new ArrayModule();
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAlternativeSyntaxForItemExists()
    {
        $this->assertArray(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 123));
    }

    public function testItemDoesNotExist()
    {
        $this->assertArray(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 124));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasOneKey()
    {
        $this->assertArray(array(123))->doesNotHaveKeys(array(0));
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assertArray(array(123))->doesNotHaveKeys(array(0, 1));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->assertArray(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b", "a"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeASubset()
    {
        $this->assertArray(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasIntegerKey()
    {
        $this->assertArray(array(123))->doesNotHaveKey(0);
    }

    public function testKeyDoesNotExist()
    {
        $this->assertArray(array(123))->doesNotHaveKey(1);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasStringKey()
    {
        $this->assertArray(array("abc" => 123))->doesNotHaveKey("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueExists()
    {
        $this->assertArray(array(123))->doesNotHaveValue(123);
    }

    public function testArrayValueDoesNotExist()
    {
        $this->assertArray(array("abc"))->doesNotHaveValue("def");
    }

    public function testZeroItemsWillAlwaysMatch()
    {
        $this->assertArray(array("foo" => 123))->hasItems(array());
    }

    public function testSingleItemIsInSet()
    {
        $this->assertArray(array("foo" => 123))->hasItems(array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSingleItemIsNotInSet()
    {
        $this->assertArray(array("foo" => 123))->hasItems(array("foo" => 124));
    }

    public function testAllItemsAreInSet()
    {
        $this->assertArray(array("foo" => 123, "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bar" => "baz"));
    }

    public function testAllItemsAreInSubset()
    {
        $this->assertArray(array("foo" => 123, "a" => "b", "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bar" => "baz"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSomeItemsAreInSubset()
    {
        $this->assertArray(array("foo" => 123, "a" => "b", "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bart" => 123));
    }

    public function testArrayValueExists1()
    {
        $this->assertArray(array(123))->hasValue(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueDoesNotExist1()
    {
        $this->assertArray(array("abc"))->hasValue("def");
    }

    public function testAlternativeSyntaxForItemExists1()
    {
        $this->assertArray(array("foo" => 123))->hasItem(array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testItemDoesNotExist1()
    {
        $this->assertArray(array("foo" => 123))->hasItem(array("foo" => 124));
    }

    public function testArrayHasOneKey1()
    {
        $this->assertArray(array(123))->hasKeys(array(0));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllKeys1()
    {
        $this->assertArray(array(123))->hasKeys(array(0, 1));
    }

    public function testArrayKeysCanBeInAnyOrder1()
    {
        $this->assertArray(array("a" => 123, "b" => 456))->hasKeys(array("b", "a"));
    }

    public function testArrayKeysCanBeASubset1()
    {
        $this->assertArray(array("a" => 123, "b" => 456))->hasKeys(array("b"));
    }

    public function testArrayHasIntegerKey1()
    {
        $this->assertArray(array(123))->hasKey(0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testKeyDoesNotExist1()
    {
        $this->assertArray(array(123))->hasKey(1);
    }

    public function testArrayHasStringKey1()
    {
        $this->assertArray(array("abc" => 123))->hasKey("abc");
    }

    public function testArrayHasOneValue()
    {
        $this->assertArray(array(123))->hasValues(array(123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllValues()
    {
        $this->assertArray(array(123))->hasValues(array(0, 123));
    }

    public function testArrayValuesCanBeInAnyOrder()
    {
        $this->assertArray(array("a" => 123, "b" => 456))
            ->hasValues(array(123, 456));
    }

    public function testArrayValuesCanBeASubset()
    {
        $this->assertArray(array("a" => 123, "b" => 456))->hasValues(array(456));
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
    {
        $this->assertArray(
            array(
                "a" => 123,
                0 => "foo",
            )
        )->isAssociative;
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed(
    )
    {
        $this->assertArray(
            array(
                5 => 123,
                10 => "foo",
            )
        )->isAssociative;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->assertArray(array(1, "foo"))->isAssociative;
    }

    public function testArrayWithZeroElements()
    {
        $this->assertArray(array())->isEmpty;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithMoreThanZeroElements()
    {
        $this->assertArray(array('a'))->isEmpty;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber1(
    )
    {
        $this->assertArray(
            array(
                "a" => 123,
                0 => "foo",
            )
        )->isNotAssociative;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed1(
    )
    {
        $this->assertArray(
            array(
                5 => 123,
                10 => "foo",
            )
        )->isNotAssociative;
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed1()
    {
        $this->assertArray(array(1, "foo"))->isNotAssociative;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithZeroElements1()
    {
        $this->assertArray(array())->isNotEmpty;
    }

    public function testArrayWithMoreThanZeroElements1()
    {
        $this->assertArray(array('a'))->isNotEmpty;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->assertArray(array())->isNotUnique;
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->assertArray(array(123, 456, 123))->isNotUnique;
    }

    public function testArrayIsUniqueIfItContainsZeroElements1()
    {
        $this->assertArray(array())->isUnique;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce1()
    {
        $this->assertArray(array(123, 456, 123))->isUnique;
    }

    /**
     * @group #311
     */
    public function testArrayCountMatches()
    {
        $this->assertArray(array(123, 456, 123))->countIs(3);
    }

    /**
     * @group #311
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayCountDoesNotMatch()
    {
        $this->assertArray(array(123, 456, 123))->countIs(2);
    }

    /**
     * @group #311
     */
    public function testArrayNotCountMatches()
    {
        $this->assertArray(array(123, 456, 123))->countIsNot(2);
    }
}
