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
	public function testEquality()
	{
		// the entire assertion can be string
		$this->assert('123 equals "123"');

		// it will understand when you mean an attribute
		$this->foo = 'bar';
		$this->assert('foo is the same as "bar"');

		// or you can create your assertion by chaining
		$this->assert($result, exactly_equals, 123);
	}

	// the assertion can be taken directly from the method name
	public function test_adding3and5_equals_8()
	{
		$this->adding3and5 = $this->calc->add(3, 5);
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
                   ->done();
```

Mocks will throw an exception for any method that is called that isn't told what to do. So maybe you need a
`niceMock`? Nice mocks work exactly like the original class but allows you to specify how to handle specific
methods:

```php
$calculator = $this->niceMock('\My\Calculator')
                   ->stub(['add' => 8])          // always return 8 for add()
                   ->done();
```

You can read more on the [Mocking](https://github.com/elliotchance/concise/wiki/Mocking) wiki page.

Matchers
--------

<!-- start matchers -->

### Arrays

* `?:array does not have key ?:string with value ?` - Assert an array does not have key and value item.
  * `?:array does not have item ?:array`
* `?:array does not have key ?:int,string` - Assert an array does not have a key.
* `?:array does not have keys ?:array` - Assert an array does not contain any keys.
* `?:array does not have value ?` - Assert an array does not have any occurrences of the given value.
  * `?:array does not contain ?`
* `?:array has key ?:string with value ?` - Assert an array has key and value item.
  * `?:array has item ?:array`
* `?:array has items ?:array` - Assert an array has all key and value items.
* `?:array has key ?:int,string` - Assert an array has key.
* `?:array has keys ?:array` - Assert an array has several keys in any order.
* `?:array has value ?` - Assert an array has at least one occurrence of the given value.
  * `?:array contains ?`
* `?:array has values ?:array` - Assert an array has several values in any order.
* `? is an array` - Assert a value is an array.
* `?:array is an associative array` - Assert an array is associative.
* `?:array is empty array` - Assert an array is empty (no elements).
  * `?:array is an empty array`
* `? is not an array` - Assert a value is not an array.
* `?:array is not an associative array` - Assert an array is associative.
* `?:array is not empty array` - Assert an array is not empty (at least one element).
  * `?:array is not an empty array`
* `?:array is not unique` - Assert that an array only has at least one element that is repeated.
* `?:array is unique` - Assert that an array only contains unique values.

### Basic

* `?:number does not equal ?:number within ?:number` - Assert two values are not close to each other.
* `? equals ?` - Assert values with no regard to exact data types.
  * `? is equal to ?`
* `?:number equals ?:number within ?:number` - Assert two values are close to each other.
* `? is exactly equal to ?` - Assert two values match data type and value.
  * `? exactly equals ?`
  * `? is the same as ?`
* `? is not null` - Assert a value is not null.
* `? is null` - Assert a value is null.
* `? not equals ?` - Assert two value do not match with no regard to type.
  * `? is not equal to ?`
  * `? does not equal ?`
* `? is not exactly equal to ?` - Assert two values are of exactly the same type and value.
  * `? does not exactly equal ?`
  * `? is not the same as ?`

### Booleans

* `false` - Always fail.
* `? is false` - Assert value is false.
* `? is true` - Assert a value is true.
* `true` - Always pass.

### Exceptions

* `?:callable does not throw ?:class` - Assert that a specific exception is not thrown.
* `?:callable does not throw exception` - Assert that no exception is thrown.
* `?:callable throws ?:class` - Assert a specific exception was thrown.
* `?:callable throws anything except ?:class` - Assert any exception except a specific one was thrown.
* `?:callable throws exactly ?:class` - Assert a specific exception was thrown.
* `?:callable throws exception` - Assert an exception was thrown.

### Files

* `?:string does not equal file ?:string` - Compare string value with the contents of a file.
* `?:string equals file ?:string` - Compare string value with the contents of a file.

### Numbers

* `?:number is between ?:number and ?:number` - A number must be between two values (inclusive).
  * `?:number between ?:number and ?:number`
* `?:number does not equal ?:number within ?:number` - Assert two values are not close to each other.
* `?:number equals ?:number within ?:number` - Assert two values are close to each other.
* `? is a number` - Assert that a value is an integer or floating-point.
* `? is an int` - Assert value is an integer type.
  * `? is an integer`
* `?:number is greater than ?:number` - A number is greater than another number.
  * `?:number greater than ?:number`
  * `?:number gt ?:number`
* `?:number is greater than or equal to ?:number` - A number is greater than or equal to another number.
  * `?:number greater than or equal ?:number`
  * `?:number gte ?:number`
* `?:number is less than ?:number` - A number is less than another number.
  * `?:number less than ?:number`
  * `?:number lt ?:number`
* `?:number is less than or equal to ?:number` - A number is less than or equal to another number.
  * `?:number less than or equal ?:number`
  * `?:number lte ?:number`
* `? is not a number` - Assert that a value is not an integer or floating-point.
* `? is not an int` - Assert a value is not an integer type.
  * `? is not an integer`
* `? is not numeric` - Assert value is not a number or string that represents a number.
* `? is numeric` - Assert value is a number or string that represents a number.
* `?:number is not between ?:number and ?:number` - A number must not be between two values (inclusive).
  * `?:number not between ?:number and ?:number`

### Objects

* `?:object does not have property ?:string` - Assert that an object does not have a property.
* `?:object has property ?:string` - Assert that an object has a property.
* `?:object has property ?:string with exact value ?` - Assert that an object has a property with a specific exact value.
* `?:object has property ?:string with value ?` - Assert that an object has a property with a specific value.
* `? is an object` - Assert value is an object.
* `?:object is an instance of ?:class` - Assert an objects class or subclass.
  * `?:object is instance of ?:class`
  * `?:object instance of ?:class`
* `? is not an object` - Assert a value is not an object.
* `?:object is not an instance of ?:class` - Assert than an object is not a class or subclass.
  * `?:object is not instance of ?:class`
  * `?:object not instance of ?:class`

### Strings

* `?:string contains string ?:string` - A string contains a substring
* `?:string contains string ?:string ignoring case` - A string contains a substring (ignoring case-sensitivity)
* `?:string does not contain string ?:string` - A string does not contain a substring.
* `?:string does not contain string ?:string ignoring case` - A string does not contain a substring (ignoring case-sensitivity)
* `?:string does not match regular expression ?:regex` - Assert a string does not match a regular expression.
  * `?:string doesnt match regular expression ?:regex`
  * `?:string does not match regex ?:regex`
  * `?:string doesnt match regex ?:regex`
* `? is a string` - Assert value is a string.
* `?:string is blank` - Assert a string is zero length.
* `? is not a string` - Assert a value is not a string.
* `?:string is not blank` - Assert a string has at least one character.
* `?:string matches regular expression ?:regex` - Assert a string matches a regular expression
  * `?:string matches regex ?:regex`
* `? does not end with ?` - Assert a string does not end with another string.
* `?:string does not equal file ?:string` - Compare string value with the contents of a file.
* `? does not start with ?` - Assert a string does not not start (begin) with another string.
* `?:string ends with ?:string` - Assert a string ends with another string.
* `?:string equals file ?:string` - Compare string value with the contents of a file.
* `?:string starts with ?:string` - Assert a string starts (begins) with another string.


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
