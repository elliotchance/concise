concise
=======

[![Build Status](https://travis-ci.org/elliotchance/concise.svg?branch=master)](https://travis-ci.org/elliotchance/concise) [![Coverage Status](https://img.shields.io/coveralls/elliotchance/concise.svg)](https://coveralls.io/r/elliotchance/concise?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elliotchance/concise/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elliotchance/concise/?branch=master)

Concise is unit test framework for using plain English and minimal code, built on PHPUnit.

Simple Example
--------------

The assertion "x is not null" is taken directly from the method name:

```php
class AttributeTest extends TestCase
{
	public function test_x_is_not_null() {
		$this->x = 123;
	}
}
```

All _attributes_ are assigned to `$this` and can be used in assertions.

### Arbitrary Code

It is often nessesary and/or easier to use arbitrary code in the assertions themselfs. The following code is equivilent:

```php
public function testMyCalculator()
{
	$this->calc = new Calculator();
	$this->answer = $self->calc->add(3, 5);
	$this->assert('answer equals 8');
}
```

```php
public function testMyCalculator()
{
	$this->calc = new Calculator();
	$this->assert('`$self->calc->add(3, 5)` equals 8');
}
```

Or, perhaps even more readable:

```php
public function setUp()
{
	parent::setUp();
	$this->calc = new Calculator();
}

public function test_adding3and5_equals_8()
{
	$this->adding3and5 = $this->calc->add(3, 5);
}
```

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
* `? is not the same as ?` - Assert two values are of exactly the same type and value.
* `? is null` - Assert a value is null.
* `? is the same as ?` - Assert two values match data type and value.
* `? is true` - Assert a value is true.
* `? matches regex ?:regex` - Assert a string matches a regular expression
* `? matches regular expression ?:regex` - Assert a string matches a regular expression
* `? not equals ?` - Assert two value do not match with no regard to type.
* `? starts with ?` - Assert a string starts (begins) with another string.
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
