concise
=======

[![Latest Stable Version](https://poser.pugx.org/elliotchance/concise/v/stable.svg)](https://packagist.org/packages/elliotchance/concise)
[![Total Downloads](https://poser.pugx.org/elliotchance/concise/downloads.svg)](https://packagist.org/packages/elliotchance/concise)

[![Build Status](https://travis-ci.org/elliotchance/concise.svg?branch=master)](https://travis-ci.org/elliotchance/concise) [![Coverage Status](https://img.shields.io/coveralls/elliotchance/concise.svg)](https://coveralls.io/r/elliotchance/concise?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elliotchance/concise/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elliotchance/concise/?branch=master)

Concise is unit test framework for using plain English and minimal code, built on PHPUnit.

Simple Example
--------------

```php
class AttributeTest extends TestCase
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
}
```

Mocking
-------

Mocking is much easier in concise, you no longer need to specify which method to mock:

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

* **[[array|Data Types]] does not have key [[string|Data Types]] with value [[mixed|Data Types]]** - Assert an array does not have key and value item.
* **[[array|Data Types]] does not have item [[array|Data Types]]** - Assert an array does not have key and value item.
* **[[array|Data Types]] does not have key [[int|Data Types]]|[[string|Data Types]]** - Assert an array does not have a key.
* **[[array|Data Types]] does not have keys [[array|Data Types]]** - Assert an array does not contain any keys.
* **[[array|Data Types]] does not have value [[mixed|Data Types]]** - Assert an array does not have any occurrences of the given value.
* **[[array|Data Types]] does not contain [[mixed|Data Types]]** - Assert an array does not have any occurrences of the given value.
* **[[array|Data Types]] has key [[string|Data Types]] with value [[mixed|Data Types]]** - Assert an array has key and value item.
* **[[array|Data Types]] has item [[array|Data Types]]** - Assert an array has key and value item.
* **[[array|Data Types]] has items [[array|Data Types]]** - Assert an array has all key and value items.
* **[[array|Data Types]] has key [[int|Data Types]]|[[string|Data Types]]** - Assert an array has key.
* **[[array|Data Types]] has keys [[array|Data Types]]** - Assert an array has several keys in any order.
* **[[array|Data Types]] has value [[mixed|Data Types]]** - Assert an array has at least one occurrence of the given value.
* **[[array|Data Types]] contains [[mixed|Data Types]]** - Assert an array has at least one occurrence of the given value.
* **[[array|Data Types]] has values [[array|Data Types]]** - Assert an array has several values in any order.
* **[[mixed|Data Types]] is an array** - Assert a value is an array.
* **[[array|Data Types]] is an associative array** - Assert an array is associative.
* **[[array|Data Types]] is empty array** - Assert an array is empty (no elements).
* **[[array|Data Types]] is an empty array** - Assert an array is empty (no elements).
* **[[mixed|Data Types]] is not an array** - Assert a value is not an array.
* **[[array|Data Types]] is not an associative array** - Assert an array is associative.
* **[[array|Data Types]] is not empty array** - Assert an array is not empty (at least one element).
* **[[array|Data Types]] is not an empty array** - Assert an array is not empty (at least one element).
* **[[array|Data Types]] is not unique** - Assert that an array only has at least one element that is repeated.
* **[[array|Data Types]] is unique** - Assert that an array only contains unique values.

### Basic

* **[[number|Data Types]] does not equal [[number|Data Types]] within [[number|Data Types]]** - Assert two values are not close to each other.
* **[[mixed|Data Types]] equals [[mixed|Data Types]]** - Assert values with no regard to exact data types.
* **[[mixed|Data Types]] is equal to [[mixed|Data Types]]** - Assert values with no regard to exact data types.
* **[[number|Data Types]] equals [[number|Data Types]] within [[number|Data Types]]** - Assert two values are close to each other.
* **[[mixed|Data Types]] is exactly equal to [[mixed|Data Types]]** - Assert two values match data type and value.
* **[[mixed|Data Types]] exactly equals [[mixed|Data Types]]** - Assert two values match data type and value.
* **[[mixed|Data Types]] is the same as [[mixed|Data Types]]** - Assert two values match data type and value.
* **[[mixed|Data Types]] is not null** - Assert a value is not null.
* **[[mixed|Data Types]] is null** - Assert a value is null.
* **[[mixed|Data Types]] not equals [[mixed|Data Types]]** - Assert two value do not match with no regard to type.
* **[[mixed|Data Types]] is not equal to [[mixed|Data Types]]** - Assert two value do not match with no regard to type.
* **[[mixed|Data Types]] does not equal [[mixed|Data Types]]** - Assert two value do not match with no regard to type.
* **[[mixed|Data Types]] is not exactly equal to [[mixed|Data Types]]** - Assert two values are of exactly the same type and value.
* **[[mixed|Data Types]] does not exactly equal [[mixed|Data Types]]** - Assert two values are of exactly the same type and value.
* **[[mixed|Data Types]] is not the same as [[mixed|Data Types]]** - Assert two values are of exactly the same type and value.

### Booleans

* **false** - Always fail.
* **[[mixed|Data Types]] is a boolean** - Assert a value is true or false.
* **[[mixed|Data Types]] is a bool** - Assert a value is true or false.
* **[[mixed|Data Types]] is false** - Assert value is false.
* **[[mixed|Data Types]] is falsy** - Assert a value is a false-like value.
* **[[mixed|Data Types]] is not a boolean** - Assert a value is not true or false.
* **[[mixed|Data Types]] is not a bool** - Assert a value is not true or false.
* **[[mixed|Data Types]] is true** - Assert a value is true.
* **[[mixed|Data Types]] is truthy** - Assert a value is a non false-like value.
* **true** - Always pass.

### Date and Time

* **date [[int|Data Types]]|[[string|Data Types]]|[[DateTime|Data Types]] is after [[int|Data Types]]|[[string|Data Types]]|[[DateTime|Data Types]]** - A date/time is after another date/time.
* **date [[int|Data Types]]|[[string|Data Types]]|[[DateTime|Data Types]] is before [[int|Data Types]]|[[string|Data Types]]|[[DateTime|Data Types]]** - A date/time is before another date/time.

### Exceptions

* **[[callable|Data Types]] does not throw [[class|Data Types]]** - Assert that a specific exception is not thrown.
* **[[callable|Data Types]] does not throw exception** - Assert that no exception is thrown.
* **[[callable|Data Types]] throws [[class|Data Types]]** - Assert a specific exception was thrown.
* **[[callable|Data Types]] throws anything except [[class|Data Types]]** - Assert any exception except a specific one was thrown.
* **[[callable|Data Types]] throws exactly [[class|Data Types]]** - Assert a specific exception was thrown.
* **[[callable|Data Types]] throws exception** - Assert an exception was thrown.

### Files

* **[[string|Data Types]] does not equal file [[string|Data Types]]** - Compare string value with the contents of a file.
* **[[string|Data Types]] equals file [[string|Data Types]]** - Compare string value with the contents of a file.

### Numbers

* **[[number|Data Types]] is between [[number|Data Types]] and [[number|Data Types]]** - A number must be between two values (inclusive).
* **[[number|Data Types]] between [[number|Data Types]] and [[number|Data Types]]** - A number must be between two values (inclusive).
* **[[number|Data Types]] does not equal [[number|Data Types]] within [[number|Data Types]]** - Assert two values are not close to each other.
* **[[number|Data Types]] equals [[number|Data Types]] within [[number|Data Types]]** - Assert two values are close to each other.
* **[[mixed|Data Types]] is a number** - Assert that a value is an integer or floating-point.
* **[[mixed|Data Types]] is an int** - Assert value is an integer type.
* **[[mixed|Data Types]] is an integer** - Assert value is an integer type.
* **[[number|Data Types]] is greater than [[number|Data Types]]** - A number is greater than another number.
* **[[number|Data Types]] greater than [[number|Data Types]]** - A number is greater than another number.
* **[[number|Data Types]] gt [[number|Data Types]]** - A number is greater than another number.
* **[[number|Data Types]] is greater than or equal to [[number|Data Types]]** - A number is greater than or equal to another number.
* **[[number|Data Types]] greater than or equal [[number|Data Types]]** - A number is greater than or equal to another number.
* **[[number|Data Types]] gte [[number|Data Types]]** - A number is greater than or equal to another number.
* **[[number|Data Types]] is less than [[number|Data Types]]** - A number is less than another number.
* **[[number|Data Types]] less than [[number|Data Types]]** - A number is less than another number.
* **[[number|Data Types]] lt [[number|Data Types]]** - A number is less than another number.
* **[[number|Data Types]] is less than or equal to [[number|Data Types]]** - A number is less than or equal to another number.
* **[[number|Data Types]] less than or equal [[number|Data Types]]** - A number is less than or equal to another number.
* **[[number|Data Types]] lte [[number|Data Types]]** - A number is less than or equal to another number.
* **[[mixed|Data Types]] is not a number** - Assert that a value is not an integer or floating-point.
* **[[mixed|Data Types]] is not an int** - Assert a value is not an integer type.
* **[[mixed|Data Types]] is not an integer** - Assert a value is not an integer type.
* **[[mixed|Data Types]] is not numeric** - Assert value is not a number or string that represents a number.
* **[[mixed|Data Types]] is numeric** - Assert value is a number or string that represents a number.
* **[[number|Data Types]] is not between [[number|Data Types]] and [[number|Data Types]]** - A number must not be between two values (inclusive).
* **[[number|Data Types]] not between [[number|Data Types]] and [[number|Data Types]]** - A number must not be between two values (inclusive).

### Objects

* **[[object|Data Types]] does not have property [[string|Data Types]]** - Assert that an object does not have a property.
* **[[object|Data Types]] has property [[string|Data Types]]** - Assert that an object has a property.
* **[[object|Data Types]] has property [[string|Data Types]] with exact value [[mixed|Data Types]]** - Assert that an object has a property with a specific exact value.
* **[[object|Data Types]] has property [[string|Data Types]] with value [[mixed|Data Types]]** - Assert that an object has a property with a specific value.
* **[[mixed|Data Types]] is an object** - Assert value is an object.
* **[[object|Data Types]]|[[class|Data Types]] is an instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[object|Data Types]]|[[class|Data Types]] is instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[object|Data Types]]|[[class|Data Types]] instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[mixed|Data Types]] is not an object** - Assert a value is not an object.
* **[[object|Data Types]] is not an instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.
* **[[object|Data Types]] is not instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.
* **[[object|Data Types]] not instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.

### Regular Expressions

* **[[string|Data Types]] does not match regular expression [[regex|Data Types]]** - Assert a string does not match a regular expression.
* **[[string|Data Types]] doesnt match regular expression [[regex|Data Types]]** - Assert a string does not match a regular expression.
* **[[string|Data Types]] does not match regex [[regex|Data Types]]** - Assert a string does not match a regular expression.
* **[[string|Data Types]] doesnt match regex [[regex|Data Types]]** - Assert a string does not match a regular expression.
* **[[string|Data Types]] matches regular expression [[regex|Data Types]]** - Assert a string matches a regular expression
* **[[string|Data Types]] matches regex [[regex|Data Types]]** - Assert a string matches a regular expression

### Strings

* **[[string|Data Types]] contains string [[string|Data Types]]** - A string contains a substring
* **[[string|Data Types]] contains string [[string|Data Types]] ignoring case** - A string contains a substring (ignoring case-sensitivity)
* **[[string|Data Types]] does not contain string [[string|Data Types]]** - A string does not contain a substring.
* **[[string|Data Types]] does not contain string [[string|Data Types]] ignoring case** - A string does not contain a substring (ignoring case-sensitivity)
* **[[mixed|Data Types]] is a string** - Assert value is a string.
* **[[string|Data Types]] is blank** - Assert a string is zero length.
* **[[mixed|Data Types]] is not a string** - Assert a value is not a string.
* **[[string|Data Types]] is not blank** - Assert a string has at least one character.
* **[[mixed|Data Types]] does not end with [[mixed|Data Types]]** - Assert a string does not end with another string.
* **[[string|Data Types]] does not equal file [[string|Data Types]]** - Compare string value with the contents of a file.
* **[[mixed|Data Types]] does not start with [[mixed|Data Types]]** - Assert a string does not not start (begin) with another string.
* **[[string|Data Types]] ends with [[string|Data Types]]** - Assert a string ends with another string.
* **[[string|Data Types]] equals file [[string|Data Types]]** - Compare string value with the contents of a file.
* **[[string|Data Types]] starts with [[string|Data Types]]** - Assert a string starts (begins) with another string.

### Types

* **[[mixed|Data Types]] is a boolean** - Assert a value is true or false.
* **[[mixed|Data Types]] is a bool** - Assert a value is true or false.
* **[[mixed|Data Types]] is a number** - Assert that a value is an integer or floating-point.
* **[[mixed|Data Types]] is a string** - Assert value is a string.
* **[[mixed|Data Types]] is an array** - Assert a value is an array.
* **[[array|Data Types]] is an associative array** - Assert an array is associative.
* **[[mixed|Data Types]] is an int** - Assert value is an integer type.
* **[[mixed|Data Types]] is an integer** - Assert value is an integer type.
* **[[mixed|Data Types]] is an object** - Assert value is an object.
* **[[mixed|Data Types]] is false** - Assert value is false.
* **[[mixed|Data Types]] is falsy** - Assert a value is a false-like value.
* **[[object|Data Types]]|[[class|Data Types]] is an instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[object|Data Types]]|[[class|Data Types]] is instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[object|Data Types]]|[[class|Data Types]] instance of [[class|Data Types]]** - Assert an objects class or subclass.
* **[[mixed|Data Types]] is not a boolean** - Assert a value is not true or false.
* **[[mixed|Data Types]] is not a bool** - Assert a value is not true or false.
* **[[mixed|Data Types]] is not a number** - Assert that a value is not an integer or floating-point.
* **[[mixed|Data Types]] is not a string** - Assert a value is not a string.
* **[[mixed|Data Types]] is not an array** - Assert a value is not an array.
* **[[array|Data Types]] is not an associative array** - Assert an array is associative.
* **[[mixed|Data Types]] is not an int** - Assert a value is not an integer type.
* **[[mixed|Data Types]] is not an integer** - Assert a value is not an integer type.
* **[[mixed|Data Types]] is not an object** - Assert a value is not an object.
* **[[object|Data Types]] is not an instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.
* **[[object|Data Types]] is not instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.
* **[[object|Data Types]] not instance of [[class|Data Types]]** - Assert than an object is not a class or subclass.
* **[[mixed|Data Types]] is not null** - Assert a value is not null.
* **[[mixed|Data Types]] is not numeric** - Assert value is not a number or string that represents a number.
* **[[mixed|Data Types]] is null** - Assert a value is null.
* **[[mixed|Data Types]] is numeric** - Assert value is a number or string that represents a number.
* **[[mixed|Data Types]] is true** - Assert a value is true.
* **[[mixed|Data Types]] is truthy** - Assert a value is a non false-like value.

### URLs

* **url [[string|Data Types]] has scheme [[string|Data Types]]** - URL has scheme.
* **url [[string|Data Types]] has host [[string|Data Types]]** - URL has host.
* **url [[string|Data Types]] has port [[int|Data Types]]** - URL has port.
* **url [[string|Data Types]] has user [[string|Data Types]]** - URL has user.
* **url [[string|Data Types]] has password [[string|Data Types]]** - URL has password.
* **url [[string|Data Types]] has path [[string|Data Types]]** - URL has path.
* **url [[string|Data Types]] has query [[string|Data Types]]** - URL has query.
* **url [[string|Data Types]] has fragment [[string|Data Types]]** - URL has fragment.
* **url [[string|Data Types]] is valid** - Validate URL.


<!-- end matchers -->

### Adding Custom Matchers

Create the matcher class:

```php
class MyMatcher extends \Concise\Matcher\AbstractMatcher
{
	/**
	 * @return array All of the syntaxes this matcher will respond to.
	 */
	public function supportedSyntaxes()
	{
		return array(
			'? equals ?',
			'? is equal to ?'
		);
	}
	
	/**
	 * Perform the match.
	 * @param string $syntax The syntax that we are evaluating (like '? equals ?').
	 * @param array $data Placeholders are matched to indicies of $data.
	 * @return TRUE on success, FALSE for failure.
	 */
	public function match($syntax, array $data = array())
	{
		return ($data[0] == $data[1]);
	}

	public function getTags()
	{
		return array(\Concise\Matcher\Tag::BASIC);
	}
}
```

Somewhere in your test (or your bootstrap) you can get the default parser and register your class:

```php
$defaultParser = \Concise\Syntax\MatcherParser::getInstance();
$defaultParser->registerMatcher(new MyMatcher());
```
