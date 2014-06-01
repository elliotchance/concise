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

	public function _test_comparisons()
	{
		return array(
			'123 matches regular expression "\\\\d+"',
		);
	}
}
