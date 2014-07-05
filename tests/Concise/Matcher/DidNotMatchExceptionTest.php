<?php

namespace Concise\Matcher;

class DidNotMatchExceptionTest extends \Concise\TestCase
{
	public function testIsATypeOfException()
	{
		$this->assert(new DidNotMatchException(), is_an_instance_of, '\Exception');
	}
}
