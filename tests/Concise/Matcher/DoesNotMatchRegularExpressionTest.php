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

	public function _test_comparison()
	{
		return '"abc" does not match regex /^f/';
	}
}
