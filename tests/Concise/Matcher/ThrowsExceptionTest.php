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
		$this->noThrow = function() {
		};
		return array(
			'doesThrow throws exception',
			'noThrow does not throw exception',
		);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExcatpionMessage The attribute to test for exception must be callable (an anonymous function)
	 */
	public function testMatcherWillOnlyAcceptCallable()
	{
		$this->matcher->match('', array(123));
	}
}
