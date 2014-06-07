<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class MatchesRegularExpressionTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new MatchesRegularExpression();
	}

	public function _test_comparison()
	{
		return '123 matches regular expression /\\d+/';
	}
}
