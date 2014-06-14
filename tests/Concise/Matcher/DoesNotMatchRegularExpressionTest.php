<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class DoesNotMatchRegularExpressionTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new DoesNotMatchRegularExpression();
	}

	public function testMatch()
	{
		$this->assert('"abc" does not match regex /^f/');
	}

	public function testFailure()
	{
		$this->assertFailure('"foo" does not match regex /^f/');
	}
}
