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
        $this->aassert(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 123));
    }

    public function testItemDoesNotExist()
    {
        $this->aassert(array("foo" => 123))
            ->doesNotHaveItem(array("foo" => 124));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasOneKey()
    {
        $this->aassert(array(123))->doesNotHaveKeys(array(0));
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->aassert(array(123))->doesNotHaveKeys([0, 1]);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->aassert(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b", "a"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayKeysCanBeASubset()
    {
        $this->aassert(array("a" => 123, "b" => 456))
            ->doesNotHaveKeys(array("b"));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasIntegerKey()
    {
        $this->aassert(array(123))->doesNotHaveKey(0);
    }

    public function testKeyDoesNotExist()
    {
        $this->aassert(array(123))->doesNotHaveKey(1);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayHasStringKey()
    {
        $this->aassert(array("abc" => 123))->doesNotHaveKey("abc");
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueExists()
    {
        $this->aassert(array(123))->doesNotHaveValue(123);
    }

    public function testArrayValueDoesNotExist()
    {
        $this->assert('["abc"] does not contain "def"');
    }

    public function testZeroItemsWillAlwaysMatch()
    {
        $this->assert(array("foo" => 123), has_items, array());
    }

    public function testSingleItemIsInSet()
    {
        $this->assert(array("foo" => 123), has_items, array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSingleItemIsNotInSet()
    {
        $this->aassert(array("foo" => 123))->hasItems(array("foo" => 124));
    }

    public function testAllItemsAreInSet()
    {
        $this->assert(
            array("foo" => 123, "bar" => "baz"),
            has_items,
            array("foo" => 123, "bar" => "baz")
        );
    }

    public function testAllItemsAreInSubset()
    {
        $this->assert(
            array("foo" => 123, "a" => "b", "bar" => "baz"),
            has_items,
            array("foo" => 123, "bar" => "baz")
        );
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testSomeItemsAreInSubset()
    {
        $this->aassert(array("foo" => 123, "a" => "b", "bar" => "baz"))
            ->hasItems(array("foo" => 123, "bart" => 123));
    }

    public function testArrayValueExists1()
    {
        $this->assert('[123] has value 123');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayValueDoesNotExist1()
    {
        $this->aassert(array("abc"))->contains("def");
    }

    public function testAlternativeSyntaxForItemExists1()
    {
        $this->assert(array("foo" => 123), has_item, array("foo" => 123));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testItemDoesNotExist1()
    {
        $this->aassert(array("foo" => 123))->hasItem(array("foo" => 124));
    }

    public function testArrayHasOneKey1()
    {
        $this->aassert(array(123))->hasKeys(array(0));
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllKeys1()
    {
        $this->aassert(array(123))->hasKeys(array(0, 1));
    }

    public function testArrayKeysCanBeInAnyOrder1()
    {
        $this->assert(array("a" => 123, "b" => 456), has_keys, array("b", "a"));
    }

    public function testArrayKeysCanBeASubset1()
    {
        $this->assert(array("a" => 123, "b" => 456), has_keys, array("b"));
    }

    public function testArrayHasIntegerKey1()
    {
        $this->assert('[123] has key 0');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testKeyDoesNotExist1()
    {
        $this->aassert(array(123))->hasKey(1);
    }

    public function testArrayHasStringKey1()
    {
        $this->assert(array("abc" => 123), has_key, "abc");
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->assert(
            $this->assert(array("abc" => 123), has_key, "abc"),
            exactly_equals,
            123
        );
    }

    public function testArrayHasOneValue()
    {
        $this->assert('[123] has values [123]');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayDoesNotContainAllValues()
    {
        $this->aassert(array(123))->hasValues(array(0, 123));
    }

    public function testArrayValuesCanBeInAnyOrder()
    {
        $this->assert(
            array("a" => 123, "b" => 456),
            has_values,
            array(123, 456)
        );
    }

    public function testArrayValuesCanBeASubset()
    {
        $this->assert(array("a" => 123, "b" => 456), has_values, array(456));
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
    {
        $this->assert(
            array(
                "a" => 123,
                0 => "foo",
            ),
            is_an_associative_array
        );
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed(
    )
    {
        $this->assert(
            array(
                5 => 123,
                10 => "foo",
            ),
            is_an_associative_array
        );
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->aassert([1, "foo"])->isAnAssociativeArray;
    }

    public function testArrayWithZeroElements()
    {
        $this->aassert(array())->isEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithMoreThanZeroElements()
    {
        $this->aassert(array('a'))->isEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber1(
    )
    {
        $this->aassert(
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
        $this->aassert(
            [
                5 => 123,
                10 => "foo",
            ]
        )->isNotAnAssociativeArray;
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed1()
    {
        $this->aassert([1, "foo"])->isNotAnAssociativeArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayWithZeroElements1()
    {
        $this->aassert(array())->isNotEmptyArray;
    }

    public function testArrayWithMoreThanZeroElements1()
    {
        $this->aassert(array('a'))->isNotEmptyArray;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->aassert(array())->isNotUnique;
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->aassert(array(123, 456, 123))->isNotUnique;
    }

    public function testArrayIsUniqueIfItContainsZeroElements1()
    {
        $this->aassert(array())->isUnique;
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce1()
    {
        $this->aassert(array(123, 456, 123))->isUnique;
    }
}
