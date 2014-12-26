concise
=======

[![Build Status](https://travis-ci.org/elliotchance/concise.svg?branch=master)](https://travis-ci.org/elliotchance/concise) [![Coverage Status](https://img.shields.io/coveralls/elliotchance/concise.svg)](https://coveralls.io/r/elliotchance/concise?branch=master) [![Latest Stable Version](https://poser.pugx.org/elliotchance/concise/v/stable.svg)](https://packagist.org/packages/elliotchance/concise) [![Total Downloads](https://poser.pugx.org/elliotchance/concise/downloads.svg)](https://packagist.org/packages/elliotchance/concise)

![](https://raw.githubusercontent.com/wiki/elliotchance/concise/image-concise-command.png)

Concise is unit test framework for using plain English and minimal code, built on PHPUnit.

Highlights include:

 * 100% compatible with PHPUnit, no changes required. You may use as many features as you like.
 * Much better mocking framework with a lot less typing.
 * Huge array of assertions to save on boilerplate code.
 * Assert and [[Verify|verify]] supported.

Simple Example
--------------

```php
class MyTest extends TestCase
{
    public function testAssertionsCanBeBuiltWithChaining()
    {
        $result = 100 + 23;
        $this->assert($result, exactly_equals, 123);

        $a = ['foo' => 'bar'];
        $this->assert($a, is_an_associative_array);
        $this->assert($a, has_key, 'foo', with_value, 'bar');
    }

    public function testAssertionsAreJustStrings()
    {
        $this->assert('123 equals "123"');
    }

    public function testAttributesAreNativelyUnderstood()
    {
        $this->foo = 'bar';
        $this->assert('foo is the same as "bar"');
    }

    public function testVerify()
    {
        $a = ['foo' => 'bar'];
        $this->verify($a, has_key, 'foo', with_value, 'bar');
        $this->verify($a, has_key, 'bar', with_value, 'baz');
        // This test will always finish, all the failed verifications
        // will be displayed at the end.
    }

    public function testNestedAssertion()
    {
        $a = ['foo' => 1.23];
        $this->assert($this->assert($a, has_key, 'foo'), equals, 1.2, within, 0.1);
    }
}
```

Mocking
-------

Mocking is much easier in concise:

```php
$calculator = $this->mock('\My\Calculator')
                   ->expect('add')->with(3, 5)->andReturn(8)
                   ->stub('clear')->andThrow(new \CantClearException())
                   ->expect('subtract')->never()
                   ->get();
```

Mocks will throw an exception for any method that is called that isn't told what to do. So maybe you need a
`niceMock`? Nice mocks work exactly like the original class but allows you to specify how to handle specific
methods:

```php
$calculator = $this->niceMock('\My\Calculator')
                   ->stub(['add' => 8])          // always return 8 for add()
                   ->get();
```

You can read more on the [Mocking](https://github.com/elliotchance/concise/wiki/Mocking) wiki page.

Matchers
--------

<!-- start matchers -->

### Arrays

* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not have key [string](https://github.com/elliotchance/concise/wiki/Data-Types) with value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not have key and value item.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not have item [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not have key and value item.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not have key [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not have a key.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not have keys [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not contain any keys.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not have value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not have any occurrences of the given value.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) does not contain [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array does not have any occurrences of the given value.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has key [string](https://github.com/elliotchance/concise/wiki/Data-Types) with value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has key and value item.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has item [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has key and value item.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has items [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has all key and value items.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has key [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has key.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has keys [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has several keys in any order.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has at least one occurrence of the given value.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) contains [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has at least one occurrence of the given value.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) has values [array](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an array has several values in any order.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an array** - Assert a value is an array.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is an associative array** - Assert an array is associative.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is empty array** - Assert an array is empty (no elements).
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is an empty array** - Assert an array is empty (no elements).
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an array** - Assert a value is not an array.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is not an associative array** - Assert an array is associative.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is not empty array** - Assert an array is not empty (at least one element).
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is not an empty array** - Assert an array is not empty (at least one element).
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is not unique** - Assert that an array only has at least one element that is repeated.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is unique** - Assert that an array only contains unique values.

### Basic

* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) does not equal [number](https://github.com/elliotchance/concise/wiki/Data-Types) within [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are not close to each other.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) equals [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert values with no regard to exact data types.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is equal to [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert values with no regard to exact data types.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) equals [number](https://github.com/elliotchance/concise/wiki/Data-Types) within [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are close to each other.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is exactly equal to [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values match data type and value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) exactly equals [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values match data type and value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is the same as [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values match data type and value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not null** - Assert a value is not null.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is null** - Assert a value is null.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) not equals [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two value do not match with no regard to type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not equal to [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two value do not match with no regard to type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) does not equal [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two value do not match with no regard to type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not exactly equal to [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are of exactly the same type and value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) does not exactly equal [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are of exactly the same type and value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not the same as [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are of exactly the same type and value.

### Booleans

* **false** - Always fail.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a boolean** - Assert a value is true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a bool** - Assert a value is true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is false** - Assert value is false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is falsy** - Assert a value is a false-like value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a boolean** - Assert a value is not true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a bool** - Assert a value is not true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is true** - Assert a value is true.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is truthy** - Assert a value is a non false-like value.
* **true** - Always pass.

### Date and Time

* **date [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)|[DateTime](https://github.com/elliotchance/concise/wiki/Data-Types) is after [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)|[DateTime](https://github.com/elliotchance/concise/wiki/Data-Types)** - A date/time is after another date/time.
* **date [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)|[DateTime](https://github.com/elliotchance/concise/wiki/Data-Types) is before [int](https://github.com/elliotchance/concise/wiki/Data-Types)|[string](https://github.com/elliotchance/concise/wiki/Data-Types)|[DateTime](https://github.com/elliotchance/concise/wiki/Data-Types)** - A date/time is before another date/time.

### Exceptions

* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) does not throw [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert that a specific exception is not thrown.
* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) does not throw exception** - Assert that no exception is thrown.
* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) throws [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a specific exception was thrown.
* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) throws anything except [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert any exception except a specific one was thrown.
* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) throws exactly [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a specific exception was thrown.
* **[callable](https://github.com/elliotchance/concise/wiki/Data-Types) throws exception** - Assert an exception was thrown.

### Files

* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not equal file [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Compare string value with the contents of a file.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) equals file [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Compare string value with the contents of a file.

### Numbers

* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is between [number](https://github.com/elliotchance/concise/wiki/Data-Types) and [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number must be between two values (inclusive).
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) between [number](https://github.com/elliotchance/concise/wiki/Data-Types) and [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number must be between two values (inclusive).
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) does not equal [number](https://github.com/elliotchance/concise/wiki/Data-Types) within [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are not close to each other.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) equals [number](https://github.com/elliotchance/concise/wiki/Data-Types) within [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert two values are close to each other.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a number** - Assert that a value is an integer or floating-point.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an int** - Assert value is an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an integer** - Assert value is an integer type.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is greater than [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) greater than [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) gt [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is greater than or equal to [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than or equal to another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) greater than or equal [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than or equal to another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) gte [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is greater than or equal to another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is less than [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) less than [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) lt [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is less than or equal to [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than or equal to another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) less than or equal [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than or equal to another number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) lte [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number is less than or equal to another number.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a number** - Assert that a value is not an integer or floating-point.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an int** - Assert a value is not an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an integer** - Assert a value is not an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not numeric** - Assert value is not a number or string that represents a number.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is numeric** - Assert value is a number or string that represents a number.
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) is not between [number](https://github.com/elliotchance/concise/wiki/Data-Types) and [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number must not be between two values (inclusive).
* **[number](https://github.com/elliotchance/concise/wiki/Data-Types) not between [number](https://github.com/elliotchance/concise/wiki/Data-Types) and [number](https://github.com/elliotchance/concise/wiki/Data-Types)** - A number must not be between two values (inclusive).

### Objects

* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) does not have property [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert that an object does not have a property.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) has property [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert that an object has a property.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) has property [string](https://github.com/elliotchance/concise/wiki/Data-Types) with exact value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert that an object has a property with a specific exact value.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) has property [string](https://github.com/elliotchance/concise/wiki/Data-Types) with value [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert that an object has a property with a specific value.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an object** - Assert value is an object.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) is an instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) is instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an object** - Assert a value is not an object.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) is not an instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) is not instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) not instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.

### Regular Expressions

* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not match regular expression [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not match a regular expression.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) doesnt match regular expression [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not match a regular expression.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not match regex [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not match a regular expression.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) doesnt match regex [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not match a regular expression.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) matches regular expression [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string matches a regular expression
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) matches regex [regex](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string matches a regular expression

### Strings

* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) contains string [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - A string contains a substring
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) contains string [string](https://github.com/elliotchance/concise/wiki/Data-Types) ignoring case** - A string contains a substring (ignoring case-sensitivity)
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not contain string [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - A string does not contain a substring.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not contain string [string](https://github.com/elliotchance/concise/wiki/Data-Types) ignoring case** - A string does not contain a substring (ignoring case-sensitivity)
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a string** - Assert value is a string.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) is blank** - Assert a string is zero length.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a string** - Assert a value is not a string.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) is not blank** - Assert a string has at least one character.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) does not end with [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not end with another string.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) does not equal file [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Compare string value with the contents of a file.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) does not start with [mixed](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string does not not start (begin) with another string.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) ends with [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string ends with another string.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) equals file [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Compare string value with the contents of a file.
* **[string](https://github.com/elliotchance/concise/wiki/Data-Types) starts with [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert a string starts (begins) with another string.

### Types

* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a boolean** - Assert a value is true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a bool** - Assert a value is true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a number** - Assert that a value is an integer or floating-point.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is a string** - Assert value is a string.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an array** - Assert a value is an array.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is an associative array** - Assert an array is associative.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an int** - Assert value is an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an integer** - Assert value is an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is an object** - Assert value is an object.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is false** - Assert value is false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is falsy** - Assert a value is a false-like value.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) is an instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) is instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types)|[class](https://github.com/elliotchance/concise/wiki/Data-Types) instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert an objects class or subclass.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a boolean** - Assert a value is not true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a bool** - Assert a value is not true or false.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a number** - Assert that a value is not an integer or floating-point.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not a string** - Assert a value is not a string.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an array** - Assert a value is not an array.
* **[array](https://github.com/elliotchance/concise/wiki/Data-Types) is not an associative array** - Assert an array is associative.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an int** - Assert a value is not an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an integer** - Assert a value is not an integer type.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not an object** - Assert a value is not an object.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) is not an instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) is not instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.
* **[object](https://github.com/elliotchance/concise/wiki/Data-Types) not instance of [class](https://github.com/elliotchance/concise/wiki/Data-Types)** - Assert than an object is not a class or subclass.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not null** - Assert a value is not null.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is not numeric** - Assert value is not a number or string that represents a number.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is null** - Assert a value is null.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is numeric** - Assert value is a number or string that represents a number.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is true** - Assert a value is true.
* **[mixed](https://github.com/elliotchance/concise/wiki/Data-Types) is truthy** - Assert a value is a non false-like value.

### URLs

* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has scheme [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has scheme.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has host [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has host.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has port [int](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has port.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has user [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has user.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has password [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has password.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has path [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has path.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has query [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has query.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) has fragment [string](https://github.com/elliotchance/concise/wiki/Data-Types)** - URL has fragment.
* **url [string](https://github.com/elliotchance/concise/wiki/Data-Types) is valid** - Validate URL.


<!-- end matchers -->
