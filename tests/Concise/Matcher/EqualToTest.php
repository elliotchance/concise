<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class EqualToTest extends TestCase
{
	public function testWillRespondToCorrectSyntax()
	{
		$matcher = new EqualTo();
		$this->assertTrue($matcher->matchesSyntax('? equals ?'));
	}
}
