<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ThrowsExceptionTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new ThrowsException();
	}

	public function _test_comparisons()
	{
		$this->doesThrow = function() {
			throw new \Exception();
		};
		return array(
			'doesThrow throws exception',
		);
	}
}
