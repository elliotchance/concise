<?php

namespace Concise\Matcher;

class DidNotMatchExceptionTest extends \PHPUnit_Framework_TestCase
{
	public function testIsATypeOfException()
	{
		$this->assertInstanceOf('\Exception', new DidNotMatchException());
	}
}
