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

* `? does not end with ?`
* `? does not equal ?`
* `? does not exactly equal ?`
* `? does not match regex ?:regex` - Check if a string does not match a regular expression.
* `? does not match regular expression ?:regex` - Check if a string does not match a regular expression.
* `? does not start with ?`
* `? doesnt match regex ?:regex` - Check if a string does not match a regular expression.
* `? doesnt match regular expression ?:regex` - Check if a string does not match a regular expression.
* `? ends with ?`
* `? equals ?` - Compare values with no regard to exact data types.
* `? exactly equals ?` - Match the value and data type.
* `? is a string` - Test for string type.
* `? is an array` - Check value is an array
* `? is an int` - Check value is strictly an integer type.
* `? is an integer` - Check value is strictly an integer type.
* `? is an object` - Check value is an object.
* `? is equal to ?` - Compare values with no regard to exact data types.
* `? is exactly equal to ?` - Match the value and data type.
* `? is false` - Check for boolean false.
* `? is not a string`
* `? is not an array`
* `? is not an int`
* `? is not an integer`
* `? is not an object`
* `? is not equal to ?`
* `? is not exactly equal to ?`
* `? is not null`
* `? is not the same as ?`
* `? is null`
* `? is the same as ?` - Match the value and data type.
* `? is true`
* `? matches regular expression ?:regex`
* `? not equals ?`
* `? starts with ?`
* `?:callable does not throw ?:class` - Verify that a specific exception is not thrown.
* `?:callable does not throw exception` - Check that no exception is thrown.
* `?:callable throws ?:class`
* `?:callable throws anything except ?:class`
* `?:callable throws exactly ?:class`
* `?:callable throws exception`
* `?:object instance of ?:class`
* `?:object is an instance of ?:class`
* `?:object is instance of ?:class`
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
