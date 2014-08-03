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
}
