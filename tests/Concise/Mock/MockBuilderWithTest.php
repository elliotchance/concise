<?php

namespace Concise\Mock;

use Concise\TestCase;

class MockBuilderWithStub
{
	public function myMethod($a)
	{
		return $a;
	}
}

class MockBuilderWithTest extends TestCase
{
	public function testMultipleWithIsAllowedForASingleMethod()
	{
		$mock = $this->mock('Concise\Mock\MockBuilderWithStub')
		             ->stub('myMethod')->with('a')->andReturn('foo')
		                               ->with('b')->andReturn('bar')
		             ->done();
		$this->assert($mock, instance_of, 'Concise\Mock\MockBuilderWithStub');
	}

	public function testMultipleWithCanChangeTheActionOfTheMethod()
	{
		$mock = $this->mock('Concise\Mock\MockBuilderWithStub')
		             ->stub('myMethod')->with('a')->andReturn('foo')
		                               ->with('b')->andReturn('bar')
		             ->done();
		$this->assert($mock->myMethod('b'), equals, 'bar');
	}

	public function testTheSecondWithActionWillNotOverrideTheFirstOne()
	{
		$mock = $this->mock('Concise\Mock\MockBuilderWithStub')
		             ->stub('myMethod')->with('a')->andReturn('foo')
		                               ->with('b')->andReturn('bar')
		             ->done();
		$this->assert($mock->myMethod('a'), equals, 'foo');
	}

	public function testSingleWithWithMultipleTimes()
	{
		$mock = $this->mock('Concise\Mock\MockBuilderWithStub')
		             ->stub('myMethod')->with('a')->twice()->andReturn('foo')
		             ->done();
		$mock->myMethod('a');
		$this->assert($mock->myMethod('a'), equals, 'foo');
	}

	public function testStringsInExpectedArgumentsMustBeEscapedCorrectly()
	{
		$mock = $this->mock('Concise\Mock\MockBuilderWithStub')
		             ->stub('myMethod')->with('"foo"')
		             ->done();
		$this->assert($mock->myMethod('"foo"'), is_null);
	}
}
