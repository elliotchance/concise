<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockExpose
{
	protected function myMethod()
	{
		return 'abc';
	}
}

class MockBuilderExposeTest extends TestCase
{
	public function testMocksCanMockStaticMethods()
	{
		$builder = $this->mock('\Concise\Mock\MockExpose');
		$this->assert($builder, equals, $builder->expose('myMethod'));
	}
}
