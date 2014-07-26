<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockStatic
{
	public static function myMethod()
	{
		return 'abc';
	}
}

class MockBuilderStaticTest extends TestCase
{
	public function testMocksCanMockStaticMethods()
	{
		$mock = $this->mock('\Concise\Mock\MockStatic')
		             ->stub(array('myMethod' => 'foo'))
		             ->done();
		$this->assert($mock->myMethod(), equals, 'foo');
	}
}
