concise
=======

[![Build Status](https://travis-ci.org/elliotchance/concise.svg?branch=master)](https://travis-ci.org/elliotchance/concise) [![Coverage Status](https://img.shields.io/coveralls/elliotchance/concise.svg)](https://coveralls.io/r/elliotchance/concise?branch=master)

Concise is unit test framework for using plain English and minimal code, built on PHPUnit.

Simple Example
--------------

The assertion "x is not null" is taken directly from the method name:

```
class AttributeTest extends TestCase
{
	public function _test_x_is_not_null() {
		$this->x = 123;
	}
}
```

All _attributes_ are assigned to `$this` and can be used in assertions. More than likely you will want to be more descritive with your tests, even if its only one assertions. You may name your testing method anything you want as long as it starts with `_test_` and returns a string that is the actual assertion:

```
public function _test_XCantBeNull()
{
	$this->x = 123;
	return 'x is not null';
}
```

This principle can be extended further to use multiple assertions per test by returning an array of assertions:

```
public function _test_XCantBeNull()
{
	$this->x = 123;
	return array(
		'x is not null',
		'x is an integer'
	);
}
```

The assertions will be be shown as separate results and all assertions will executed in regardless of the outcomes of other individual assertions in the same test.

### Arbitrary Code

It is often nessesary and/or easier to use arbitrary code in the assertions themselfs. The following code is equivilent:

```
public function _test_my_calculator()
{
	$this->calc = new Calculator();
	$this->answer = $self->calc->add(3, 5);
	return 'answer equals 8';
}
```

```
public function _test_my_calculator()
{
	$this->calc = new Calculator();
	return '`$self->calc->add(3, 5)` equals 8';
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

```
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

```
$defaultParser = \Concise\Syntax\MatcherParser::getInstance();
$defaultParser->registerMatcher(new MyMatcher());
```

Data Sets (Data Providers)
--------------------------

Data set allow you to generate many assertions from a set of values. This works much the same as how PHPUnit uses data providers. Values are substituted into `?` placeholders like:

```
class AdditionTest extends TestCase
{
	public function _test_adding_some_stuff()
	{
		$this->calc = new Calculator();
		$cases = array(
			array(1, 1, 2),
			array(3, 5, 8),
		);
		return $this->assertionsForDataSet(
		    '`$self->calc->add(?, ?)` equals `?`',
			$cases
		);
	}
}
```

**Note: The placeholder `?` must be inside a backtick block, even if it is by itself.**