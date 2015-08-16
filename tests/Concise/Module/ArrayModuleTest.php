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
        $this->assertFailure(
            array("foo" => 123),
            does_not_have_key,
            "foo",
            with_value,
            123
        );
    }

    public function testAlternativeSyntaxForItemExists()
    {
        $this->assertFailure(
            array("foo" => 123),
            does_not_have_item,
            array("foo" => 123)
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
        $this->assertFailure(
            array("foo" => 123, "bar" => "baz"),
            does_not_have_key,
            "foo",
            with_value,
            123
        );
    }

    public function testArrayHasOneKey()
    {
        $this->assertFailure('[123] does not have keys [0]');
    }

    public function testArrayDoesNotContainAllKeys()
    {
        $this->assert('[123] does not have keys [0,1]');
    }

    public function testArrayKeysCanBeInAnyOrder()
    {
        $this->assertFailure(
            array("a" => 123, "b" => 456),
            does_not_have_keys,
            array("b", "a")
        );
    }

    public function testArrayKeysCanBeASubset()
    {
        $this->assertFailure(
            array("a" => 123, "b" => 456),
            does_not_have_keys,
            array("b")
        );
    }

    public function testArrayHasIntegerKey()
    {
        $this->assertFailure('[123] does not have key 0');
    }

    public function testKeyDoesNotExist()
    {
        $this->assert('[123] does not have key 1');
    }

    public function testArrayHasStringKey()
    {
        $this->assertFailure(array("abc" => 123), does_not_have_key, "abc");
    }

    public function testArrayValueExists()
    {
        $this->assertFailure('[123] does not have value 123');
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
        $this->assertFailure(
            array("foo" => 123),
            has_items,
            array("foo" => 124)
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
        $this->assertFailure(
            array("foo" => 123, "a" => "b", "bar" => "baz"),
            has_items,
            array("foo" => 123, "bart" => 123)
        );
    }

    public function testArrayValueExists1()
    {
        $this->assert('[123] has value 123');
    }

    public function testArrayValueDoesNotExist1()
    {
        $this->assertFailure('["abc"] contains "def"');
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
        $this->assertFailure(
            array("foo" => 123),
            has_item,
            array("foo" => 124)
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
        $this->assertFailure('[123] has keys [0,1]');
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
        $this->assertFailure('[123] has key 1');
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
        $this->assertFailure('[123] has values [0,123]');
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
        $x = array(
            "a" => 123,
            0 => "foo",
        );
        $this->assert($x, is_an_associative_array);
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed()
    {
        $x = array(
            5 => 123,
            10 => "foo",
        );
        $this->assert($x, is_an_associative_array);
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->assertFailure('[1,"foo"] is an associative array');
    }

    public function testArrayWithZeroElements()
    {
        $this->assert(array(), is_empty_array);
    }

    public function testArrayWithMoreThanZeroElements()
    {
        $this->assertFailure(array('a'), is_empty_array);
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber1()
    {
        $x = array(
            "a" => 123,
            0 => "foo",
        );
        $this->assertFailure($x, is_not_an_associative_array);
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed1()
    {
        $x = array(
            5 => 123,
            10 => "foo",
        );
        $this->assertFailure($x, is_not_an_associative_array);
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed1()
    {
        $this->assert('[1,"foo"] is not an associative array');
    }

    public function testArrayWithZeroElements1()
    {
        $this->assertFailure(array(), is_not_empty_array);
    }

    public function testArrayWithMoreThanZeroElements1()
    {
        $this->assert(array('a'), is_not_empty_array);
    }

    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->assertFailure(array(), is_not_unique);
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->assert(array(123, 456, 123), is_not_unique);
    }

    public function testArrayIsUniqueIfItContainsZeroElements1()
    {
        $this->assert(array(), is_unique);
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce1()
    {
        $this->assertFailure(array(123, 456, 123), is_unique);
    }
}
