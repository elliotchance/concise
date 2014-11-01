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

* `?:array does not have key ?:string with value ?` - Assert an array does not have key and value item.
* `?:array does not have item ?:array` - Assert an array does not have key and value item.
* `?:array does not have key ?:int,string` - Assert an array does not have a key.
* `?:array does not have keys ?:array` - Assert an array does not contain any keys.
* `?:array does not have value ?` - Assert an array does not have any occurrences of the given value.
* `?:array does not contain ?` - Assert an array does not have any occurrences of the given value.
* `?:array has key ?:string with value ?` - Assert an array has key and value item.
* `?:array has item ?:array` - Assert an array has key and value item.
* `?:array has items ?:array` - Assert an array has all key and value items.
* `?:array has key ?:int,string` - Assert an array has key.
* `?:array has keys ?:array` - Assert an array has several keys in any order.
* `?:array has value ?` - Assert an array has at least one occurrence of the given value.
* `?:array contains ?` - Assert an array has at least one occurrence of the given value.
* `?:array has values ?:array` - Assert an array has several values in any order.
* `? is an array` - Assert a value is an array.
* `?:array is an associative array` - Assert an array is associative.
* `?:array is empty array` - Assert an array is empty (no elements).
* `?:array is an empty array` - Assert an array is empty (no elements).
* `? is not an array` - Assert a value is not an array.
* `?:array is not an associative array` - Assert an array is associative.
* `?:array is not empty array` - Assert an array is not empty (at least one element).
* `?:array is not an empty array` - Assert an array is not empty (at least one element).
* `?:array is not unique` - Assert that an array only has at least one element that is repeated.
* `?:array is unique` - Assert that an array only contains unique values.

### Basic

* `?:number does not equal ?:number within ?:number` - Assert two values are not close to each other.
* `? equals ?` - Assert values with no regard to exact data types.
* `? is equal to ?` - Assert values with no regard to exact data types.
* `?:number equals ?:number within ?:number` - Assert two values are close to each other.
* `? is exactly equal to ?` - Assert two values match data type and value.
* `? exactly equals ?` - Assert two values match data type and value.
* `? is the same as ?` - Assert two values match data type and value.
* `? is not null` - Assert a value is not null.
* `? is null` - Assert a value is null.
* `? not equals ?` - Assert two value do not match with no regard to type.
* `? is not equal to ?` - Assert two value do not match with no regard to type.
* `? does not equal ?` - Assert two value do not match with no regard to type.
* `? is not exactly equal to ?` - Assert two values are of exactly the same type and value.
* `? does not exactly equal ?` - Assert two values are of exactly the same type and value.
* `? is not the same as ?` - Assert two values are of exactly the same type and value.

### Booleans

* `false` - Always fail.
* `? is a boolean` - Assert a value is true or false.
* `? is a bool` - Assert a value is true or false.
* `? is false` - Assert value is false.
* `? is falsy` - Assert a value is a false-like value.
* `? is not a boolean` - Assert a value is not true or false.
* `? is not a bool` - Assert a value is not true or false.
* `? is true` - Assert a value is true.
* `? is truthy` - Assert a value is a non false-like value.
* `true` - Always pass.

### Date and Time

* `date ?:int,string,DateTime is after ?:int,string,DateTime` - A date/time is after another date/time.
* `date ?:int,string,DateTime is before ?:int,string,DateTime` - A date/time is before another date/time.

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
* `?:number between ?:number and ?:number` - A number must be between two values (inclusive).
* `?:number does not equal ?:number within ?:number` - Assert two values are not close to each other.
* `?:number equals ?:number within ?:number` - Assert two values are close to each other.
* `? is a number` - Assert that a value is an integer or floating-point.
* `? is an int` - Assert value is an integer type.
* `? is an integer` - Assert value is an integer type.
* `?:number is greater than ?:number` - A number is greater than another number.
* `?:number greater than ?:number` - A number is greater than another number.
* `?:number gt ?:number` - A number is greater than another number.
* `?:number is greater than or equal to ?:number` - A number is greater than or equal to another number.
* `?:number greater than or equal ?:number` - A number is greater than or equal to another number.
* `?:number gte ?:number` - A number is greater than or equal to another number.
* `?:number is less than ?:number` - A number is less than another number.
* `?:number less than ?:number` - A number is less than another number.
* `?:number lt ?:number` - A number is less than another number.
* `?:number is less than or equal to ?:number` - A number is less than or equal to another number.
* `?:number less than or equal ?:number` - A number is less than or equal to another number.
* `?:number lte ?:number` - A number is less than or equal to another number.
* `? is not a number` - Assert that a value is not an integer or floating-point.
* `? is not an int` - Assert a value is not an integer type.
* `? is not an integer` - Assert a value is not an integer type.
* `? is not numeric` - Assert value is not a number or string that represents a number.
* `? is numeric` - Assert value is a number or string that represents a number.
* `?:number is not between ?:number and ?:number` - A number must not be between two values (inclusive).
* `?:number not between ?:number and ?:number` - A number must not be between two values (inclusive).

### Objects

* `?:object does not have property ?:string` - Assert that an object does not have a property.
* `?:object has property ?:string` - Assert that an object has a property.
* `?:object has property ?:string with exact value ?` - Assert that an object has a property with a specific exact value.
* `?:object has property ?:string with value ?` - Assert that an object has a property with a specific value.
* `? is an object` - Assert value is an object.
* `?:object is an instance of ?:class` - Assert an objects class or subclass.
* `?:object is instance of ?:class` - Assert an objects class or subclass.
* `?:object instance of ?:class` - Assert an objects class or subclass.
* `? is not an object` - Assert a value is not an object.
* `?:object is not an instance of ?:class` - Assert than an object is not a class or subclass.
* `?:object is not instance of ?:class` - Assert than an object is not a class or subclass.
* `?:object not instance of ?:class` - Assert than an object is not a class or subclass.

### Regular Expressions

* `?:string does not match regular expression ?:regex` - Assert a string does not match a regular expression.
* `?:string doesnt match regular expression ?:regex` - Assert a string does not match a regular expression.
* `?:string does not match regex ?:regex` - Assert a string does not match a regular expression.
* `?:string doesnt match regex ?:regex` - Assert a string does not match a regular expression.
* `?:string matches regular expression ?:regex` - Assert a string matches a regular expression
* `?:string matches regex ?:regex` - Assert a string matches a regular expression

### Strings

* `?:string contains string ?:string` - A string contains a substring
* `?:string contains string ?:string ignoring case` - A string contains a substring (ignoring case-sensitivity)
* `?:string does not contain string ?:string` - A string does not contain a substring.
* `?:string does not contain string ?:string ignoring case` - A string does not contain a substring (ignoring case-sensitivity)
* `? is a string` - Assert value is a string.
* `?:string is blank` - Assert a string is zero length.
* `? is not a string` - Assert a value is not a string.
* `?:string is not blank` - Assert a string has at least one character.
* `? does not end with ?` - Assert a string does not end with another string.
* `?:string does not equal file ?:string` - Compare string value with the contents of a file.
* `? does not start with ?` - Assert a string does not not start (begin) with another string.
* `?:string ends with ?:string` - Assert a string ends with another string.
* `?:string equals file ?:string` - Compare string value with the contents of a file.
* `?:string starts with ?:string` - Assert a string starts (begins) with another string.

### Types

* `? is a boolean` - Assert a value is true or false.
* `? is a bool` - Assert a value is true or false.
* `? is a number` - Assert that a value is an integer or floating-point.
* `? is a string` - Assert value is a string.
* `? is an array` - Assert a value is an array.
* `?:array is an associative array` - Assert an array is associative.
* `? is an int` - Assert value is an integer type.
* `? is an integer` - Assert value is an integer type.
* `? is an object` - Assert value is an object.
* `? is false` - Assert value is false.
* `? is falsy` - Assert a value is a false-like value.
* `?:object is an instance of ?:class` - Assert an objects class or subclass.
* `?:object is instance of ?:class` - Assert an objects class or subclass.
* `?:object instance of ?:class` - Assert an objects class or subclass.
* `? is not a boolean` - Assert a value is not true or false.
* `? is not a bool` - Assert a value is not true or false.
* `? is not a number` - Assert that a value is not an integer or floating-point.
* `? is not a string` - Assert a value is not a string.
* `? is not an array` - Assert a value is not an array.
* `?:array is not an associative array` - Assert an array is associative.
* `? is not an int` - Assert a value is not an integer type.
* `? is not an integer` - Assert a value is not an integer type.
* `? is not an object` - Assert a value is not an object.
* `?:object is not an instance of ?:class` - Assert than an object is not a class or subclass.
* `?:object is not instance of ?:class` - Assert than an object is not a class or subclass.
* `?:object not instance of ?:class` - Assert than an object is not a class or subclass.
* `? is not null` - Assert a value is not null.
* `? is not numeric` - Assert value is not a number or string that represents a number.
* `? is null` - Assert a value is null.
* `? is numeric` - Assert value is a number or string that represents a number.
* `? is true` - Assert a value is true.
* `? is truthy` - Assert a value is a non false-like value.

### URLs

* `url ?:string has scheme ?:string` - URL has scheme.
* `url ?:string has host ?:string` - URL has host.
* `url ?:string has port ?:int` - URL has port.
* `url ?:string has user ?:string` - URL has user.
* `url ?:string has password ?:string` - URL has password.
* `url ?:string has path ?:string` - URL has path.
* `url ?:string has query ?:string` - URL has query.
* `url ?:string has fragment ?:string` - URL has fragment.
* `url ?:string is valid` - Validate URL.


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
