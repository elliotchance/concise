<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ContainsStringTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new ContainsString();
	}

	public function testSuccessIfStringContainsASubstring()
	{
		$this->assert('foobar', contains_string, 'oob');
	}

	public function testFailsIfSubstringDoesNotExistInString()
	{
		$this->assertFailure('foobar', contains_string, 'baz');
	}
}
