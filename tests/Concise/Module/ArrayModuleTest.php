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
        $this->matcher = new ArrayModule();
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAlternativeSyntaxForItemExists()
    {
        $this->assert(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 123));
    }

    public function testItemDoesNotExist()
    {
        $this->assert(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 124));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasOneKey()
    {
        $this->assert(array(123))->doesNotHaveKeys(array(0));
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assert(array(123))->doesNotHaveKeys([0, 1]);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->assert(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b", "a"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeASubset()
    {
        $this->assert(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasIntegerKey()
    {
        $this->assert(array(123))->doesNotHaveKey(0);
    }

    public function testKeyDoesNotExist()
    {
        $this->assert(array(123))->doesNotHaveKey(1);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasStringKey()
    {
        $this->assert(array("abc" => 123))->doesNotHaveKey("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueExists()
    {
        $this->assert(array(123))->doesNotHaveValue(123);
    }

    public function testArrayValueDoesNotExist()
    {
        $this->assert(array("abc"))->doesNotContain("def");
    }

    public function testZeroItemsWillAlwaysMatch()
    {
        $this->assert(array("foo" => 123))->hasItems(array());
    }

    public function testSingleItemIsInSet()
    {
        $this->assert(array("foo" => 123))->hasItems(array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSingleItemIsNotInSet()
    {
        $this->assert(array("foo" => 123))->hasItems(array("foo" => 124));
    }

    public function testAllItemsAreInSet()
    {
        $this->assert(array("foo" => 123, "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bar" => "baz"));
    }

    public function testAllItemsAreInSubset()
    {
        $this->assert(array("foo" => 123, "a" => "b", "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bar" => "baz"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSomeItemsAreInSubset()
    {
        $this->assert(array("foo" => 123, "a" => "b", "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bart" => 123));
    }

    public function testArrayValueExists1()
    {
        $this->assert(array(123))->hasValue(123);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueDoesNotExist1()
    {
        $this->assert(array("abc"))->contains("def");
    }

    public function testAlternativeSyntaxForItemExists1()
    {
        $this->assert(array("foo" => 123))->hasItem(array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testItemDoesNotExist1()
    {
        $this->assert(array("foo" => 123))->hasItem(array("foo" => 124));
    }

    public function testArrayHasOneKey1()
    {
        $this->assert(array(123))->hasKeys(array(0));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllKeys1()
    {
        $this->assert(array(123))->hasKeys(array(0, 1));
    }

    public function testArrayKeysCanBeInAnyOrder1()
    {
        $this->assert(array("a" => 123, "b" => 456))->hasKeys(array("b", "a"));
    }

    public function testArrayKeysCanBeASubset1()
    {
        $this->assert(array("a" => 123, "b" => 456))->hasKeys(array("b"));
    }

    public function testArrayHasIntegerKey1()
    {
        $this->assert(array(123))->hasKey(0);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testKeyDoesNotExist1()
    {
        $this->assert(array(123))->hasKey(1);
    }

    public function testArrayHasStringKey1()
    {
        $this->assert(array("abc" => 123))->hasKey("abc");
    }

    public function testArrayHasOneValue()
    {
        $this->assert(array(123))->hasValues(array(123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllValues()
    {
        $this->assert(array(123))->hasValues(array(0, 123));
    }

    public function testArrayValuesCanBeInAnyOrder()
    {
        $this->assert(array("a" => 123, "b" => 456))
            ->hasValues(array(123, 456));
    }

    public function testArrayValuesCanBeASubset()
    {
        $this->assert(array("a" => 123, "b" => 456))->hasValues(array(456));
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
    {
        $this->assert(
            array(
                "a" => 123,
                0 => "foo",
            )
        )->isAnAssociativeArray;
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed(
    )
    {
        $this->assert(
            array(
                5 => 123,
                10 => "foo",
            )
        )->isAnAssociativeArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->assert([1, "foo"])->isAnAssociativeArray;
    }

    public function testArrayWithZeroElements()
    {
        $this->assert(array())->isEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithMoreThanZeroElements()
    {
        $this->assert(array('a'))->isEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber1(
    )
    {
        $this->assert(
            [
                "a" => 123,
                0 => "foo",
            ]
        )->isNotAnAssociativeArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed1(
    )
    {
        $this->assert(
            [
                5 => 123,
                10 => "foo",
            ]
        )->isNotAnAssociativeArray;
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed1()
    {
        $this->assert([1, "foo"])->isNotAnAssociativeArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithZeroElements1()
    {
        $this->assert(array())->isNotEmptyArray;
    }

    public function testArrayWithMoreThanZeroElements1()
    {
        $this->assert(array('a'))->isNotEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->assert(array())->isNotUnique;
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->assert(array(123, 456, 123))->isNotUnique;
    }

    public function testArrayIsUniqueIfItContainsZeroElements1()
    {
        $this->assert(array())->isUnique;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce1()
    {
        $this->assert(array(123, 456, 123))->isUnique;
    }
}
