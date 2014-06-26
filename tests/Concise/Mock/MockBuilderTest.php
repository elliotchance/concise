<?php

namespace Concise\Mock;

use \Concise\TestCase;

class MockBuilderTest extends TestCase
{
	public function testMockCanBeCreatedFromAClassThatExists()
	{
		$generator = new MockBuilder($this, '\Concise\TestCase');
		$this->mock = $generator->getMock();
		$this->assert('mock instance of \Concise\TestCase');
	}
}
