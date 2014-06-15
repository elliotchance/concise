<?php

namespace Concise\Matcher;

class DidNotMatchExceptionTest extends \Concise\TestCase
{
	public function testIsATypeOfException()
	{
		$this->assert('`new \Concise\Matcher\DidNotMatchException()` is an instance of \Exception');
	}
}
