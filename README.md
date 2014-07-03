concise
=======

[![Build Status](https://travis-ci.org/elliotchance/concise.svg?branch=master)](https://travis-ci.org/elliotchance/concise) [![Coverage Status](https://img.shields.io/coveralls/elliotchance/concise.svg)](https://coveralls.io/r/elliotchance/concise?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elliotchance/concise/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elliotchance/concise/?branch=master)

Concise is unit test framework for using plain English and minimal code, built on PHPUnit.

Simple Example
--------------

```php
class AttributeTest extends TestCase
{
	public function testEquality() {
		// the entire assertion can be string
		$this->assert('123 equals "123"');

		// it will understand when you mean an attribute
		$this->foo = 'bar';
		$this->assert('foo is the same as "bar"');

		// or you can create your assertion by chaining
		$this->assert($result, exactly_equals, 123);

		// assertThat for convenience
		assertThat($answer, is_an_associative_array);

		// while generally not recommended, you can use code blocks (notice $self instead of $this)
		$this->assert('`$self->calc->add(3, 5)` equals 8');
	}

	// the assertion can be taken directly from the method name
	public function test_adding3and5_equals_8() {
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

* `? does not end with ?` - Assert a string does not end with another string.
* `? does not equal ?` - Assert two value do not match with no regard to type.
* `? does not exactly equal ?` - Assert two values are of exactly the same type and value.
* `? does not match regex ?:regex` - Assert a string does not match a regular expression.
* `? does not match regular expression ?:regex` - Assert a string does not match a regular expression.
* `? does not start with ?` - Assert a string does not not start (begin) with another string.
* `? doesnt match regex ?:regex` - Assert a string does not match a regular expression.
* `? doesnt match regular expression ?:regex` - Assert a string does not match a regular expression.
* `? ends with ?` - Assert a string ends with another string.
* `? equals ?` - Assert values with no regard to exact data types.
* `? exactly equals ?` - Assert two values match data type and value.
* `? is a number` - Assert that a value is an integer or floating-point.
* `? is a string` - Assert value is a string.
* `? is an array` - Assert a value is an array.
* `? is an int` - Assert value is an integer type.
* `? is an integer` - Assert value is an integer type.
* `? is an object` - Assert value is an object.
* `? is equal to ?` - Assert values with no regard to exact data types.
* `? is exactly equal to ?` - Assert two values match data type and value.
* `? is false` - Assert value is false.
* `? is not a number` - Assert that a value is not an integer or floating-point.
* `? is not a string` - Assert a value is not a string.
* `? is not an array` - Assert a value is not an array.
* `? is not an int` - Assert a value is not an integer type.
* `? is not an integer` - Assert a value is not an integer type.
* `? is not an object` - Assert a value is not an object.
* `? is not equal to ?` - Assert two value do not match with no regard to type.
* `? is not exactly equal to ?` - Assert two values are of exactly the same type and value.
* `? is not null` - Assert a value is not null.
* `? is not numeric` - Assert value is not a number or string that represents a number.
* `? is not the same as ?` - Assert two values are of exactly the same type and value.
* `? is null` - Assert a value is null.
* `? is numeric` - Assert value is a number or string that represents a number.
* `? is the same as ?` - Assert two values match data type and value.
* `? is true` - Assert a value is true.
* `? matches regex ?:regex` - Assert a string matches a regular expression
* `? matches regular expression ?:regex` - Assert a string matches a regular expression
* `? not equals ?` - Assert two value do not match with no regard to type.
* `? starts with ?` - Assert a string starts (begins) with another string.
* `?:array contains ?` - Assert an array has at least one occurrence of the given value.
* `?:array does not contain ?` - Assert an array does not have any occurrences of the given value.
* `?:array does not have key ?:int,string` - Assert an array does not have a key.
* `?:array does not have keys ?:array` - Assert an array does not contain any keys.
* `?:array does not have value ?` - Assert an array does not have any occurrences of the given value.
* `?:array has key ?:int,string` - Assert an array has key.
* `?:array has keys ?:array` - Assert an array has several keys in any order.
* `?:array has value ?` - Assert an array has at least one occurrence of the given value.
* `?:array is an associative array` - Assert an array is associative.
* `?:array is not an associative array` - Assert an array is associative.
* `?:callable does not throw ?:class` - Assert that a specific exception is not thrown.
* `?:callable does not throw exception` - Assert that no exception is thrown.
* `?:callable throws ?:class` - Assert a specific exception was thrown.
* `?:callable throws anything except ?:class` - Assert any exception except a specific one was thrown.
* `?:callable throws exactly ?:class` - Assert a specific exception was thrown.
* `?:callable throws exception` - Assert an exception was thrown.
* `?:object instance of ?:class` - Assert an objects class or subclass.
* `?:object is an instance of ?:class` - Assert an objects class or subclass.
* `?:object is instance of ?:class` - Assert an objects class or subclass.
* `false` - Always fail.
* `true` - Always pass.

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
}
```

Somewhere in your test (or your bootstrap) you can get the default parser and register your class:

```php
$defaultParser = \Concise\Syntax\MatcherParser::getInstance();
$defaultParser->registerMatcher(new MyMatcher());
```
