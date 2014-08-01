<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class DoesNotContainStringTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new DoesNotContainString();
	}

	public function testSuccessIfStringContainsASubstring()
	{
		$this->assertFailure('foobar', does_not_contain_string, 'oob');
	}

	public function testFailsIfSubstringDoesNotExistInString()
	{
		$this->assert('foobar', does_not_contain_string, 'baz');
	}

	public function testIsSensitiveToCase()
	{
		$this->assert('foobar', does_not_contain_string, 'Foo');
	}
}
