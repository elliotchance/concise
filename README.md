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

* `? does not equal ?`
* `? equals ?`
* `? is a string`
* `? is an array`
* `? is an int`
* `? is an integer`
* `? is an object`
* `? is equal to ?`
* `? is false`
* `? is not a string`
* `? is not an array`
* `? is not an int`
* `? is not an integer`
* `? is not an object`
* `? is not equal to ?`
* `? is not null`
* `? is null`
* `? is true`
* `? not equals ?`
* `false`
* `true`

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