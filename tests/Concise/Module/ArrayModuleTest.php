<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class ArrayModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ArrayModule();
    }

    public function testKeyValuePairExists()
    {
        $this->aassertFailure(
            $this->aassert(array("foo" => 123))
                ->doesNotHaveKey("foo")
                ->withValue(123)
        );
    }

    public function testAlternativeSyntaxForItemExists()
    {
        $this->aassertFailure(
            $this->aassert(array("foo" => 123))
                ->doesNotHaveItem(array("foo" => 123))
        );
    }

    public function testItemDoesNotExist()
    {
        $this->assert(
            array("foo" => 123),
            does_not_have_item,
            array("foo" => 124)
        );
    }

    public function testItemExistsInMultipleItems()
    {
        $this->aassertFailure(
            $this->aassert(
                array("foo" => 123, "bar" => "baz")
            )->doesNotHaveKey("foo")->withValue(123)
        );
    }

    public function testArrayHasOneKey()
    {
        $this->aassertFailure(
            $this->aassert(array(123))->doesNotHaveKeys(array(0))
        );
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assert('[123] does not have keys [0,1]');
    }

    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->aassertFailure(
            $this->aassert(array("a" => 123, "b" => 456))->doesNotHaveKeys(
                array("b", "a")
            )
        );
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->aassertFailure(
            $this->aassert(array("a" => 123, "b" => 456))->doesNotHaveKeys(
                array("b")
            )
        );
    }

    public function testArrayHasIntegerKey()
    {
        $this->aassertFailure($this->aassert(array(123))->doesNotHaveKey(0));
    }

    public function testKeyDoesNotExist()
    {
        $this->assert('[123] does not have key 1');
    }

    public function testArrayHasStringKey()
    {
        $this->aassertFailure(
            $this->aassert(array("abc" => 123))->doesNotHaveKey("abc")
        );
    }

    public function testArrayValueExists()
    {
        $this->aassertFailure(
            $this->aassert(array(123))->doesNotHaveValue(123)
        );
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

    public function testSingleItemIsNotInSet()
    {
        $this->aassertFailure(
            $this->aassert(array("foo" => 123))->hasItems(array("foo" => 124))
        );
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

    public function testSomeItemsAreInSubset()
    {
        $this->aassertFailure(
            $this->aassert(array("foo" => 123, "a" => "b", "bar" => "baz"))
                ->hasItems(array("foo" => 123, "bart" => 123))
        );
    }

    public function testArrayValueExists1()
    {
        $this->assert('[123] has value 123');
    }

    public function testArrayValueDoesNotExist1()
    {
        $this->aassertFailure(
            $this->aassert(array("abc"))->contains("def")
        );
    }

    public function testKeyValuePairExists1()
    {
        $this->assert(array("foo" => 123), has_key, "foo", with_value, 123);
    }

    public function testAlternativeSyntaxForItemExists1()
    {
        $this->assert(array("foo" => 123), has_item, array("foo" => 123));
    }

    public function testItemDoesNotExist1()
    {
        $this->aassertFailure(
            $this->aassert(array("foo" => 123))->hasItem(array("foo" => 124))
        );
    }

    public function testItemExistsInMultipleItems1()
    {
        $this->assert(
            array("foo" => 123, "bar" => "baz"),
            has_key,
            "foo",
            with_value,
            123
        );
    }

    public function testArrayHasOneKey1()
    {
        $this->assert('[123] has keys [0]');
    }

    public function testArrayDoesNotContainAllKeys1()
    {
        $this->aassertFailure(
            $this->aassert(array(123))->hasKeys(array(0, 1))
        );
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

    public function testKeyDoesNotExist1()
    {
        $this->aassertFailure(
            $this->aassert(array(123))->hasKey(1)
        );
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

    /**
     * @group #219
     */
    public function testNestedAssertionFailure()
    {
        $this->assertFailure(
            $this->assert(array("abc" => 123), has_key, "abc"),
            exactly_equals,
            124
        );
    }

    public function testArrayHasOneValue()
    {
        $this->assert('[123] has values [123]');
    }

    public function testArrayDoesNotContainAllValues()
    {
        $this->aassertFailure(
            $this->aassert(array(123))->hasValues(array(0, 123))
        );
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

    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->aassertFailure($this->aassert([1, "foo"])->isAnAssociativeArray);
    }

    public function testArrayWithZeroElements()
    {
        $this->aassert(array())->isEmptyArray;
    }

    public function testArrayWithMoreThanZeroElements()
    {
        $this->aassertFailure($this->aassert(array('a'))->isEmptyArray);
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber1(
    )
    {
        $this->aassertFailure(
            $this->aassert(
                [
                    "a" => 123,
                    0 => "foo",
                ]
            )->isNotAnAssociativeArray
        );
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed1(
    )
    {
        $this->aassertFailure(
            $this->aassert(
                [
                    5 => 123,
                    10 => "foo",
                ]
            )->isNotAnAssociativeArray
        );
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed1()
    {
        $this->aassert([1, "foo"])->isNotAnAssociativeArray;
    }

    public function testArrayWithZeroElements1()
    {
        $this->aassertFailure(
            $this->aassert(array())->isNotEmptyArray
        );
    }

    public function testArrayWithMoreThanZeroElements1()
    {
        $this->aassert(array('a'))->isNotEmptyArray;
    }

    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->aassertFailure(
            $this->aassert(array())->isNotUnique
        );
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->aassert(array(123, 456, 123))->isNotUnique;
    }

    public function testArrayIsUniqueIfItContainsZeroElements1()
    {
        $this->aassert(array())->isUnique;
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce1()
    {
        $this->aassertFailure($this->aassert(array(123, 456, 123))->isUnique);
    }
}
