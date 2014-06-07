<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class DoesNotMatchRegularExpressionTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new DoesNotMatchRegularExpression();
	}

	public function _test_comparison()
	{
		return '"abc" does not match regex /^f/';
	}
}
